<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('murids')->latest()->get();
        
        return view('guru.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('guru.kelas.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:100',
            'kode_kelas' => 'required|string|max:20|unique:kelas,kode_kelas',
            'deskripsi' => 'nullable|string',
            'wali_kelas' => 'nullable|string|max:100',
            'tingkat' => 'required|in:A,B,B1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'kode_kelas' => $request->kode_kelas,
            'deskripsi' => $request->deskripsi,
            'wali_kelas' => $request->wali_kelas,
            'tingkat' => $request->tingkat,
            'status' => 'aktif',
        ]);

        return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit($kelas)
    {
        $kelasModel = Kelas::findOrFail($kelas);
        return view('guru.kelas.edit', [
            'kelasId' => $kelasModel->id,
            'kelas' => $kelasModel
        ]);
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:100',
            'kode_kelas' => 'required|string|max:20|unique:kelas,kode_kelas,' . $id,
            'deskripsi' => 'nullable|string',
            'wali_kelas' => 'nullable|string|max:100',
            'tingkat' => 'required|in:A,B,B1',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $kelas->update($request->only(['nama_kelas', 'kode_kelas', 'deskripsi', 'wali_kelas', 'tingkat', 'status']));

        return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
