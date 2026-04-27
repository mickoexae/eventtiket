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
        // 1. Validasi: Tambahkan min:1 untuk harga dan stok
        $request->validate([
            'id_event' => 'required',
            'nama_tiket' => 'required|array',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:1', // Validasi tiap item di array harga
            'stok' => 'required|array',
            'stok.*' => 'required|numeric|min:1',  // Validasi tiap item di array stok
        ]);

        $event = Event::with('venue')->findOrFail($request->id_event);
        $kapasitasVenue = $event->venue->kapasitas;
        $totalStokBaru = array_sum($request->stok);
        $stokTerdaftar = Tiket::where('id_event', $request->id_event)->sum('stok');

        if (($stokTerdaftar + $totalStokBaru) > $kapasitasVenue) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Gagal! Total tiket ({$totalStokBaru}) + tiket terdaftar ({$stokTerdaftar}) melebihi kapasitas venue ({$kapasitasVenue}).");
        }

        foreach ($request->nama_tiket as $key => $val) {
            if (!empty($val)) {
                $tiket = new Tiket();
                $tiket->id_event = $request->id_event;
                $tiket->nama_tiket = $val;
                // Menggunakan data yang sudah tervalidasi
                $tiket->harga = $request->harga[$key];
                $tiket->stok = $request->stok[$key];
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
        // 2. Validasi Update: Tambahkan min:1
        $request->validate([
            'nama_tiket' => 'required',
            'harga' => 'required|numeric|min:1',
            'stok' => 'required|numeric|min:1',
        ]);

        $tiket = Tiket::findOrFail($id);

        $event = Event::with('venue')->findOrFail($tiket->id_event);
        $kapasitasVenue = $event->venue->kapasitas;

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