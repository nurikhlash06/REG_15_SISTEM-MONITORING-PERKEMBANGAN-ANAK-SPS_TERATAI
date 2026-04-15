<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\Kelas;
use App\Models\User;
use App\Traits\HasAspekStyles;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class MuridController extends Controller
{
    use HasAspekStyles;

    public function index(Request $request)
    {
        $query = Murid::query()->with(['orangTuaUser', 'kelas']);

        // Filter berdasarkan kelas jika ada parameter kelas
        if ($request->has('kelas') && !empty($request->kelas)) {
            $query->where('kelas_id', $request->kelas);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $murid = $query->latest()->paginate(10)->withQueryString();
        
        // Ambil info kelas untuk header jika sedang difilter
        $selectedKelas = null;
        if ($request->has('kelas') && !empty($request->kelas)) {
            $selectedKelas = Kelas::find($request->kelas);
        }

        return view('guru.murid.index', compact('murid', 'selectedKelas'));
    }

    public function create()
    {
        $orangTuaUsers = User::query()
            ->where('role', 'orang_tua')
            ->orderBy('name')
            ->get();

        $kelas = Kelas::where('status', 'aktif')->orderBy('nama_kelas')->get();

        return view('guru.murid.create', compact('orangTuaUsers', 'kelas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'nik' => ['nullable', 'string', 'size:16'],
            'nisn' => ['nullable', 'string', 'size:10'],
            'kelas_id' => ['nullable', 'exists:kelas,id'],
            'alamat' => ['nullable', 'string'],
            'berat_badan' => ['nullable', 'numeric', 'min:0'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:0'],
            'lingkar_kepala' => ['nullable', 'numeric', 'min:0'],
            'nama_orang_tua' => ['required', 'string', 'max:255'],
            'email_orang_tua' => ['nullable', 'email', 'max:255'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('murid', 'public');
        }

        // Logic untuk otomatisasi akun orang tua
        if (!empty($data['email_orang_tua'])) {
            $user = \App\Models\User::where('email', $data['email_orang_tua'])->first();
            
            if (!$user) {
                $user = \App\Models\User::create([
                    'email' => $data['email_orang_tua'],
                    'name' => $data['nama_orang_tua'],
                    'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                    'role' => 'orang_tua'
                ]);
            } else {
                $user->update([
                    'name' => $data['nama_orang_tua'],
                ]);
            }
            $data['id_user_orangtua'] = $user->id;
        }

        Murid::create($data);

        return redirect()->route('guru.murid.index')->with('success', 'Murid berhasil ditambahkan.');
    }

    public function show(Murid $murid)
    {
        $murid->load(['perkembangan' => function ($q) {
            $q->latest();
        }]);

        $aspekSummary = [];
        $colorMap = $this->getColorMap();
        $aspekOptions = array_keys($colorMap);
        $dynamicStyles = $this->generateDynamicStyles($aspekOptions);
        $skorLabels = $this->getSkorLabels();
        
        foreach ($aspekOptions as $opt) {
            $latest = $murid->perkembangan->where('aspek', $opt)->first();
            $styles = $colorMap[$opt] ?? [
                'bg' => 'secondary', 'icon' => 'bi-circle', 'text' => '#64748b',
                'icon_bg' => '#f1f5f9', 'card_bg' => '#f8fafc'
            ];

            $aspekSummary[] = (object) [
                'name' => $opt,
                'skor' => $latest ? $latest->skor : 0,
                'tanggal' => $latest ? $latest->tanggal : null,
                'catatan' => $latest ? $latest->catatan : null,
                'styles' => $styles,
            ];
        }

        return view('guru.murid.show', compact('murid', 'aspekSummary', 'dynamicStyles', 'skorLabels'));
    }

    public function edit(Murid $murid)
    {
        $orangTuaUsers = User::query()
            ->where('role', 'orang_tua')
            ->orderBy('name')
            ->get();

        $kelas = Kelas::where('status', 'aktif')->orderBy('nama_kelas')->get();

        return view('guru.murid.edit', compact('murid', 'orangTuaUsers', 'kelas'));
    }

    public function update(Request $request, Murid $murid)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'nik' => ['nullable', 'string', 'size:16'],
            'nisn' => ['nullable', 'string', 'size:10'],
            'kelas_id' => ['nullable', 'exists:kelas,id'],
            'alamat' => ['nullable', 'string'],
            'berat_badan' => ['nullable', 'numeric', 'min:0'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:0'],
            'lingkar_kepala' => ['nullable', 'numeric', 'min:0'],
            'nama_orang_tua' => ['required', 'string', 'max:255'],
            'email_orang_tua' => ['nullable', 'email', 'max:255'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($murid->foto) {
                Storage::disk('public')->delete($murid->foto);
            }
            $data['foto'] = $request->file('foto')->store('murid', 'public');
        }

        // Logic untuk otomatisasi akun orang tua
        if (!empty($data['email_orang_tua'])) {
            $user = \App\Models\User::where('email', $data['email_orang_tua'])->first();
            
            if (!$user) {
                $user = \App\Models\User::create([
                    'email' => $data['email_orang_tua'],
                    'name' => $data['nama_orang_tua'],
                    'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                    'role' => 'orang_tua'
                ]);
            } else {
                $user->update([
                    'name' => $data['nama_orang_tua'],
                ]);
            }
            $data['id_user_orangtua'] = $user->id;
        }

        $murid->update($data);

        return redirect()->route('guru.murid.index')->with('success', 'Murid berhasil diperbarui.');
    }

    public function destroy(Murid $murid)
    {
        $murid->delete();

        return redirect()->route('guru.murid.index')->with('success', 'Murid berhasil dihapus.');
    }
}

