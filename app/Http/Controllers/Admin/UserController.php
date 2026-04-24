<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // app/Http/Controllers/Admin/UserController.php

public function index(Request $request)
{
    // Ambil input kata kunci dari form search
    $search = $request->input('search');

    // Query dasar: hanya ambil role 'user'
    $query = \App\Models\User::where('role', 'user');

    // Jika ada kata kunci search, cari berdasarkan nama atau email
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('nama', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    $users = $query->latest()->get();

    return view('admin.user.index', compact('users'));
}

// app/Http/Controllers/UserController.php

public function tiketSaya()
{
    $orders = Order::with('details.tiket') // Pakai 'details', bukan 'order_details'
        ->where('id_user', auth()->id())
        ->get();

    return view('user.tiket_saya', compact('orders'));
}

    public function toggleStatus($id_user) // Pastikan variabelnya $id_user
{
    $user = \App\Models\User::findOrFail($id_user);
    $user->is_active = !$user->is_active;
    $user->save();

    return back()->with('success', 'Status berhasil diubah!');
}
}