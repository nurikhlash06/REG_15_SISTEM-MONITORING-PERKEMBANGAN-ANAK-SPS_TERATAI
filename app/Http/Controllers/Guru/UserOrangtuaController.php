<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserOrangtuaController extends Controller
{
    public function index()
    {
        $orangtua = User::where('role', 'orang_tua')
            ->withCount(['murid' => function($query) {
                $query->from('murid');
            }])
            ->orderBy('name')
            ->get();

        return view('guru.orangtua.index', compact('orangtua'));
    }

    public function create()
    {
        return view('guru.orangtua.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'orang_tua',
        ]);

        return redirect()
            ->route('guru.orangtua.index')
            ->with('success', 'Akun orang tua baru berhasil dibuat.');
    }

    public function destroy(User $orangtua)
    {
        if ($orangtua->role !== 'orang_tua') {
            return back()->with('error', 'Hanya akun orang tua yang dapat dihapus.');
        }

        // Putuskan hubungan dengan murid (opsional, tergantung logic)
        \App\Models\Murid::where('id_user_orangtua', $orangtua->id)->update(['id_user_orangtua' => null]);

        $orangtua->delete();

        return redirect()
            ->route('guru.orangtua.index')
            ->with('success', 'Akun orang tua berhasil dihapus.');
    }
}