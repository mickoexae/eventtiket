<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\Event;

class TiketController extends Controller
{
    public function index()
    {
        $tikets = Tiket::with(['event' => function($query) {
            $query->withTrashed();
        }])->get();
        return view('admin.tiket.index', compact('tikets'));
    }

    public function create()
    {
        $events = Event::all(); 
        return view('admin.tiket.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_event' => 'required',
            'nama_tiket' => 'required|array',
            'harga' => 'required|array',
            'stok' => 'required|array',
        ]);

        // 1. Ambil data Event beserta Venue-nya untuk cek kapasitas
        $event = Event::with('venue')->findOrFail($request->id_event);
        $kapasitasVenue = $event->venue->kapasitas;

        // 2. Hitung total stok yang sedang diinput di form
        $totalStokBaru = array_sum($request->stok);

        // 3. Hitung stok tiket yang sudah terdaftar di database untuk event ini
        $stokTerdaftar = Tiket::where('id_event', $request->id_event)->sum('stok');

        // 4. Validasi: Jika (Lama + Baru) > Kapasitas Venue
        if (($stokTerdaftar + $totalStokBaru) > $kapasitasVenue) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Gagal! Total tiket ({$totalStokBaru}) + tiket terdaftar ({$stokTerdaftar}) melebihi kapasitas venue ({$kapasitasVenue}).");
        }

        // 5. Jika aman, baru simpan
        foreach ($request->nama_tiket as $key => $val) {
            if (!empty($val)) {
                $tiket = new Tiket();
                $tiket->id_event = $request->id_event;
                $tiket->nama_tiket = $val;
                $tiket->harga = $request->harga[$key] ?? 0;
                $tiket->stok = $request->stok[$key] ?? 0;
                $tiket->save();
            }
        }

        return redirect()->route('admin.tiket.index')->with('success', 'Kategori tiket berhasil ditambahkan!');
    }

    public function edit($id) {
        $tiket = Tiket::findOrFail($id);
        return view('admin.tiket.edit', compact('tiket')); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_tiket' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $tiket = Tiket::findOrFail($id);

        // --- VALIDASI KAPASITAS UNTUK UPDATE ---
        $event = Event::with('venue')->findOrFail($tiket->id_event);
        $kapasitasVenue = $event->venue->kapasitas;

        // Hitung total stok tiket lain milik event ini (kecuali tiket yang sedang di-update)
        $stokLain = Tiket::where('id_event', $tiket->id_event)
                         ->where('id_tiket', '!=', $id)
                         ->sum('stok');

        if (($stokLain + $request->stok) > $kapasitasVenue) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Gagal! Perubahan stok melebihi kapasitas venue ({$kapasitasVenue}). Sisa slot tersedia: " . ($kapasitasVenue - $stokLain));
        }

        $tiket->update($request->all());

        return redirect()->route('admin.tiket.index')->with('success', 'Stok tiket berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->delete();

        return redirect()->route('admin.tiket.index')->with('success', 'Tiket berhasil dipindahkan ke kotak sampah!');
    }

    public function trash()
    {
        $tikets = Tiket::onlyTrashed()->with(['event' => function($q){
            $q->withTrashed();
        }])->get();
        return view('admin.tiket.trash', compact('tikets'));
    }

    public function restore($id)
    {
        $tiket = Tiket::withTrashed()->findOrFail($id);
        
        // --- VALIDASI KAPASITAS SAAT RESTORE ---
        $event = Event::with('venue')->findOrFail($tiket->id_event);
        $stokAktif = Tiket::where('id_event', $tiket->id_event)->sum('stok');

        if (($stokAktif + $tiket->stok) > $event->venue->kapasitas) {
            return redirect()->back()->with('error', "Gagal restore! Kapasitas venue sudah penuh.");
        }

        $tiket->restore();
        return redirect()->route('admin.tiket.trash')->with('success', 'Tiket berhasil dipulihkan!');
    }

    public function forceDelete($id)
    {
        $tiket = Tiket::withTrashed()->findOrFail($id);
        $tiket->forceDelete();

        return redirect()->route('admin.tiket.trash')->with('success', 'Tiket dihapus permanen!');
    }
}