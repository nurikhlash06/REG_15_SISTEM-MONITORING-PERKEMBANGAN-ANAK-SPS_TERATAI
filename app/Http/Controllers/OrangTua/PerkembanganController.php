<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\Perkembangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerkembanganController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $muridQuery = Murid::query()
            ->where('id_user_orangtua', $userId)
            ->orderBy('nama_lengkap');

        $murid = $muridQuery->get();

        $selectedMuridId = $request->integer('murid_id') ?: null;
        $selectedAspek = $request->string('aspek') ?: null;

        $perkembanganQuery = Perkembangan::query()
            ->with('murid')
            ->whereHas('murid', function ($q) use ($userId) {
                $q->where('id_user_orangtua', $userId);
            })
            ->latest('tanggal');

        if ($selectedMuridId) {
            $perkembanganQuery->where('murid_id', $selectedMuridId);
        }

        if ($selectedAspek) {
            $perkembanganQuery->where('aspek', $selectedAspek);
        }

        $perkembangan = $perkembanganQuery->paginate(10)->withQueryString();

        return view('orangtua.perkembangan.index', compact('murid', 'perkembangan', 'selectedMuridId', 'selectedAspek'));
    }

    public function show(Perkembangan $perkembangan)
    {
        $userId = Auth::id();

        // Proteksi: hanya orang tua yang memiliki murid ini yang boleh melihat
        if (! $perkembangan->murid || $perkembangan->murid->id_user_orangtua !== $userId) {
            abort(403);
        }

        $perkembangan->load('murid', 'guruUser');

        return view('orangtua.perkembangan.show', compact('perkembangan'));
    }
}

