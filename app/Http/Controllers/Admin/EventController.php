<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Tiket; // Pastikan Model Tiket di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('venue')->get();
        return view('admin.event.index', compact('events'));
    }

    // Jangan lupa import di bagian atas file jika belum ada:
// use App\Models\Tiket;
// use Illuminate\Http\Request;

public function checkoutMultiple(Request $request)
{
    // 1. Ambil semua input jumlah tiket
    $jumlahInput = $request->input('jumlah', []);

    // 2. Filter hanya tiket yang jumlahnya lebih dari 0
    $selectedTickets = [];
    $total_harga = 0;

    foreach ($jumlahInput as $id_tiket => $qty) {
        if ($qty > 0) {
            // Cari data tiket di database
            $tiket = Tiket::find($id_tiket);
            
            if ($tiket) {
                // Pastikan stok mencukupi (Opsional tapi bagus untuk keamanan)
                if ($tiket->stok < $qty) {
                    return redirect()->back()->with('error', "Stok tiket {$tiket->nama_tiket} tidak mencukupi.");
                }

                $subtotal = $tiket->harga * $qty;
                
                $selectedTickets[] = [
                    'id_tiket' => $tiket->id_tiket,
                    'nama'     => $tiket->nama_tiket,
                    'qty'      => $qty,
                    'harga'    => $tiket->harga,
                    'subtotal' => $subtotal
                ];

                $total_harga += $subtotal;
            }
        }
    }

    // 3. Jika user tidak pilih tiket sama sekali, balikin ke halaman detail
    if (empty($selectedTickets)) {
        return redirect()->back()->with('error', 'Silakan pilih minimal 1 tiket sebelum checkout.');
    }

    // 4. Lempar data ke view checkout.blade.php
    return view('user.checkout', [
        'selectedTickets' => $selectedTickets,
        'total_harga'     => $total_harga
    ]);
}

    public function create()
    {
        $venues = Venue::all();
        return view('admin.event.create', compact('venues'));
    }

    public function store(Request $request)
{
    // 1. Validasi dulu
    $request->validate([
        'nama_event' => 'required',
        'id_venue' => 'required',
        'tanggal' => 'required',
        'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 2. Buat objek Event dulu (Biar variabel $event tidak null)
    $event = new \App\Models\Event();
    $event->nama_event = $request->nama_event;
    $event->id_venue = $request->id_venue;
    $event->tanggal = $request->tanggal;
    // $event->deskripsi = $request->deskripsi;

    // 3. Baru proses Foto (Sekarang $event sudah ada isinya, jadi nggak null lagi)
    if ($request->hasFile('foto')) {
    $file = $request->file('foto');
    
    // Beri nama unik agar tidak bentrok
    $nama_file = time() . "_" . $file->getClientOriginalName();
    
    // PAKSA pindah langsung ke folder public/storage/events
    $file->move(public_path('storage/events'), $nama_file); 
    
    // Simpan di database: 'events/nama_file.jpg'
    $event->foto = 'events/' . $nama_file;
}

    // 4. Simpan ke Database
    $event->save();

    return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan!');
}

    public function edit($id)
{
    // Ambil event beserta tiket-tiket yang dimilikinya
    $event = \App\Models\Event::with('tikets')->findOrFail($id);
    
    // Ambil data venue untuk dropdown
    $venues = \App\Models\Venue::all();

    return view('admin.event.edit', compact('event', 'venues'));
}

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'nama_event' => 'required',
            'id_venue' => 'required',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama_tiket.*' => 'required',
        ]);

        $data = $request->only(['nama_event', 'id_venue', 'tanggal']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($event->foto && Storage::exists('public/events/' . $event->foto)) {
                Storage::delete('public/events/' . $event->foto);
            }

            // Upload foto baru
            $file = $request->file('foto');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/events', $namaFile);
            $data['foto'] = $namaFile;
        }

        $event->update($data);

        // --- UPDATE LOGIC UNTUK TIKET ---
        // Hapus tiket lama milik event ini, lalu isi ulang dengan data baru dari form
        Tiket::where('id_event', $id)->delete();

        if ($request->has('nama_tiket')) {
            foreach ($request->nama_tiket as $key => $val) {
                Tiket::create([
                    'id_event' => $event->id_event,
                    'nama_tiket' => $request->nama_tiket[$key],
                    'harga' => $request->harga_tiket[$key],
                    'kuota' => $request->stok_tiket[$key], // SUDAH DIPERBAIKI: Menggunakan 'kuota' sesuai DB
                ]);
            }
        }

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy($id)
{
    // 1. Cari data event-nya
    $event = \App\Models\Event::findOrFail($id);

    try {
        // 2. Mulai proses penghapusan berantai
        foreach ($event->tikets as $tiket) {
            // Hapus Cucu: Riwayat transaksi di order_detail yang pakai ID Tiket ini
            \DB::table('order_detail')->where('id_tiket', $tiket->id_tiket)->delete();
            
            // Hapus Anak: Data Tiket itu sendiri
            $tiket->delete();
        }

        // 3. Terakhir, hapus Bapak: Data Event-nya
        $event->delete();

        return redirect()->route('admin.event.index')->with('success', 'Event, Tiket, dan Riwayat Transaksi berhasil dihapus semua!');
        
    } catch (\Exception $e) {
        return redirect()->route('admin.event.index')->with('error', 'Gagal menghapus: ' . $e->getMessage());
    }
}
}