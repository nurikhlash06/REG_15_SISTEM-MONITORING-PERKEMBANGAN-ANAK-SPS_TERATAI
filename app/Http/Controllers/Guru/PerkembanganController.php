<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\Perkembangan;
 use App\Traits\HasAspekStyles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerkembanganController extends Controller
{
    use HasAspekStyles;

    public function index(Request $request)
    {
        $query = Perkembangan::query()->with('murid')->latest('tanggal');

        $selectedMurid = null;

        // Filter berdasarkan murid_id (dropdown)
        if ($request->filled('murid_id')) {
            $muridId = $request->integer('murid_id');
            $query->where('murid_id', $muridId);
            $selectedMurid = Murid::find($muridId);
        }

        // Filter berdasarkan pencarian nama murid (input text)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('murid', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
            
            // Jika ada pencarian, ambil murid pertama yang cocok untuk menampilkan "Semua Aspek"
            if (!$selectedMurid) {
                $selectedMurid = Murid::where('nama_lengkap', 'like', "%{$search}%")->first();
            }
        }

        // Filter berdasarkan aspek
        if ($request->filled('aspek')) {
            $query->where('aspek', $request->aspek);
        }

        $perkembangan = $query->paginate(10)->withQueryString();
        
        // Hitung ringkasan capaian jika ada murid yang terpilih/dicari
        $aspekSummary = [];
        $colorMap = $this->getColorMap();
        $dynamicStyles = '';
        
        if ($selectedMurid) {
            $aspekOptions = array_keys($colorMap);
            $dynamicStyles = $this->generateDynamicStyles($aspekOptions);
            
            foreach ($aspekOptions as $opt) {
                $latest = Perkembangan::where('murid_id', $selectedMurid->id)
                    ->where('aspek', $opt)
                    ->latest('tanggal')
                    ->first();

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
        }

        // Data pendukung untuk filter dropdown
        $murid = Murid::query()->orderBy('nama_lengkap')->get();
        $aspekOptions = array_keys($colorMap);
        $skorLabels = $this->getSkorLabels();

        return view('guru.perkembangan.index', compact('perkembangan', 'murid', 'aspekOptions', 'selectedMurid', 'aspekSummary', 'dynamicStyles', 'skorLabels'));
    }

    public function create(Request $request)
    {
        $murid = Murid::query()->orderBy('nama_lengkap')->get();
        $selectedMuridId = $request->integer('murid_id') ?: null;
        $selectedAspek = $request->string('aspek') ?: null;
        $aspekOptions = array_keys($this->getColorMap());
        $skorLabels = $this->getSkorLabels();
        $perkembangan = null;

        return view('guru.perkembangan.create', compact('murid', 'selectedMuridId', 'selectedAspek', 'aspekOptions', 'skorLabels', 'perkembangan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'murid_id' => ['required', 'integer', 'exists:murid,id'],
            'tanggal' => ['required', 'date'],
            'aspek' => ['required', 'string', 'max:255'],
            'skor' => ['required', 'integer', 'min:1', 'max:4'],
            'catatan' => ['required', 'string'],
        ]);

        $data['user_id_guru'] = Auth::id();

        Perkembangan::create($data);

        return redirect()->route('guru.perkembangan.index')->with('success', 'Perkembangan berhasil ditambahkan.');
    }

    public function edit(Perkembangan $perkembangan)
    {
        $murid = Murid::query()->orderBy('nama_lengkap')->get();
        $aspekOptions = array_keys($this->getColorMap());
        $skorLabels = $this->getSkorLabels();

        return view('guru.perkembangan.edit', compact('perkembangan', 'murid', 'aspekOptions', 'skorLabels'));
    }

    public function update(Request $request, Perkembangan $perkembangan)
    {
        $data = $request->validate([
            'murid_id' => ['required', 'integer', 'exists:murid,id'],
            'tanggal' => ['required', 'date'],
            'aspek' => ['required', 'string', 'max:255'],
            'skor' => ['required', 'integer', 'min:1', 'max:4'],
            'catatan' => ['required', 'string'],
        ]);

        $perkembangan->update($data);

        return redirect()->route('guru.perkembangan.index')->with('success', 'Perkembangan berhasil diperbarui.');
    }

    public function destroy(Perkembangan $perkembangan)
    {
        $perkembangan->delete();

        return redirect()->route('guru.perkembangan.index')->with('success', 'Perkembangan berhasil dihapus.');
    }
}

