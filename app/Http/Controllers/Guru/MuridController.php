<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class MuridController extends Controller
{
    public function index()
    {
        $murid = Murid::query()->with('orangTuaUser')->latest()->paginate(10);

        return view('guru.murid.index', compact('murid'));
    }

    public function create()
    {
        $orangTuaUsers = User::query()
            ->where('role', 'orang_tua')
            ->orderBy('name')
            ->get();

        return view('guru.murid.create', compact('orangTuaUsers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'nik' => ['nullable', 'string', 'size:16'],
            'nisn' => ['nullable', 'string', 'size:10'],
            'rombel' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'berat_badan' => ['nullable', 'numeric', 'min:0'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:0'],
            'tinggi_lutut' => ['nullable', 'numeric', 'min:0'],
            'nama_orang_tua' => ['required', 'string', 'max:255'],
            'email_orang_tua' => ['nullable', 'email', 'max:255'],
            'password_orang_tua' => ['nullable', 'string', 'min:8'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('murid', 'public');
        }

        // Logic untuk otomatisasi akun orang tua
        if (!empty($data['email_orang_tua'])) {
            $user = \App\Models\User::updateOrCreate(
                ['email' => $data['email_orang_tua']],
                [
                    'name' => $data['nama_orang_tua'],
                    'password' => \Illuminate\Support\Facades\Hash::make($data['password_orang_tua'] ?? '12345678'),
                    'role' => 'orang_tua'
                ]
            );
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

        return view('guru.murid.show', compact('murid'));
    }

    public function edit(Murid $murid)
    {
        $orangTuaUsers = User::query()
            ->where('role', 'orang_tua')
            ->orderBy('name')
            ->get();

        return view('guru.murid.edit', compact('murid', 'orangTuaUsers'));
    }

    public function update(Request $request, Murid $murid)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'nik' => ['nullable', 'string', 'size:16'],
            'nisn' => ['nullable', 'string', 'size:10'],
            'rombel' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'berat_badan' => ['nullable', 'numeric', 'min:0'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:0'],
            'tinggi_lutut' => ['nullable', 'numeric', 'min:0'],
            'nama_orang_tua' => ['required', 'string', 'max:255'],
            'email_orang_tua' => ['nullable', 'email', 'max:255'],
            'password_orang_tua' => ['nullable', 'string', 'min:8'],
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
            $user = \App\Models\User::updateOrCreate(
                ['email' => $data['email_orang_tua']],
                [
                    'name' => $data['nama_orang_tua'],
                    'password' => \Illuminate\Support\Facades\Hash::make($data['password_orang_tua'] ?? '12345678'),
                    'role' => 'orang_tua'
                ]
            );
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

