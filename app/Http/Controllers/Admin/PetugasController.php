<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
{
    // Mengambil user dengan role petugas
    $petugas = User::where('role', 'petugas')->latest()->get();
    return view('admin.petugas.index', compact('petugas'));
}

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas', // Set otomatis jadi petugas
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Akun petugas berhasil dihapus!');
    }
}
