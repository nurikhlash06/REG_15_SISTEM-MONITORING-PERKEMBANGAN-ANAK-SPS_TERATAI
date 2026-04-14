<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\Perkembangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerkembanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Perkembangan::query()->with('murid')->latest();

        if ($request->filled('murid_id')) {
            $query->where('murid_id', $request->integer('murid_id'));
        }

        $perkembangan = $query->paginate(10)->withQueryString();

        return view('guru.perkembangan.index', compact('perkembangan'));
    }

    public function create(Request $request)
    {
        $murid = Murid::query()->orderBy('nama_lengkap')->get();
        $selectedMuridId = $request->integer('murid_id') ?: null;

        return view('guru.perkembangan.create', compact('murid', 'selectedMuridId'));
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

        return view('guru.perkembangan.edit', compact('perkembangan', 'murid'));
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

