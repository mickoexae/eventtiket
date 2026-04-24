<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher; // Tambahkan ini agar pemanggilan lebih rapi
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        // Menggunakan Voucher::all() karena sudah di-use di atas
        $vouchers = Voucher::all();
        return view('admin.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'kode_voucher' => 'required|unique:voucher,kode_voucher',
        'potongan'     => 'required|numeric',
        'kuota'        => 'required|integer',
        'status'       => 'required|in:aktif,nonaktif',
    ]);

    $data = $request->all();
    
    // Logika Otomatis: Jika kuota 0, paksa status jadi nonaktif
    if ($request->kuota <= 0) {
        $data['status'] = 'nonaktif';
    }

    Voucher::create($data);

    return redirect()->route('admin.voucher.index')->with('success', 'Voucher berhasil dibuat!');
}
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'kode_voucher' => 'required|unique:voucher,kode_voucher,'.$id.',id_voucher',
        'potongan'     => 'required|numeric',
        'kuota'        => 'required|integer',
        'status'       => 'required|in:aktif,nonaktif',
    ]);

    $voucher = Voucher::findOrFail($id);
    $data = $request->all();

    // Logika Otomatis: Jika kuota diubah jadi 0 atau kurang, paksa status nonaktif
    if ($request->kuota <= 0) {
        $data['status'] = 'nonaktif';
    }

    $voucher->update($data);

    return redirect()->route('admin.voucher.index')->with('success', 'Voucher diperbarui!');
}

   public function destroy($id)
{
    // Cari data voucher
    $voucher = Voucher::findOrFail($id);
    
    // Hapus data
    $voucher->delete();

    // REDIRECT DENGAN NOTIFIKASI
    // Pastikan 'success' di sini sama dengan @if(session('success')) di app.blade.php
    return redirect()->route('admin.voucher.index')->with('success', 'Voucher berhasil dihapus selamanya!');
}
}