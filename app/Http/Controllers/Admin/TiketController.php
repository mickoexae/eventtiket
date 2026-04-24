<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\Event;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $tikets = \App\Models\Tiket::with('event')->get();
    return view('admin.tiket.index', compact('tikets'));
}

public function create()
{
    // 1. Ambil semua data event dari database
    $events = Event::all(); 

    // 2. Kirim variabel $events ke view admin/tiket/create.blade.php
    return view('admin.tiket.create', compact('events'));
}

public function store(Request $request)
{
    // 1. Validasi agar tidak kosong
    $request->validate([
        'id_event' => 'required',
        'nama_tiket' => 'required|array',
        'harga' => 'required|array',
        'stok' => 'required|array', // Di Blade kamu namanya 'stok[]'
    ]);

    // 2. Loop data array-nya
    foreach ($request->nama_tiket as $key => $val) {
        if (!empty($val)) {
            $tiket = new \App\Models\Tiket();
            $tiket->id_event = $request->id_event;
            $tiket->nama_tiket = $val;
            
            // Ambil dari $request->harga sesuai index $key
            $tiket->harga = isset($request->harga[$key]) ? $request->harga[$key] : 0;
            
            // Ambil dari $request->stok (SESUAIKAN DENGAN BLADE)
            $tiket->stok = isset($request->stok[$key]) ? $request->stok[$key] : 0;
            
            $tiket->save();
        }
    }

    // 3. Redirect ke halaman index tiket
    return redirect()->route('admin.tiket.index')->with('success', 'Kategori tiket berhasil ditambahkan!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
    $tiket = \App\Models\Tiket::findOrFail($id);
    // Pastikan view-nya mengarah ke folder tiket, bukan event
    return view('admin.tiket.edit', compact('tiket')); 
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_tiket' => 'required',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric',
    ]);

    $tiket = \App\Models\Tiket::findOrFail($id);
    
    // Update data tiketnya saja
    $tiket->update([
        'nama_tiket' => $request->nama_tiket,
        'harga' => $request->harga,
        'stok' => $request->stok,
    ]);

    return redirect()->route('admin.tiket.index')->with('success', 'Stok tiket berhasil diperbarui!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
