<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue; // Import Model di sini biar gak perlu nulis lengkap di bawah
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        // Secara otomatis hanya mengambil data yang belum di-soft delete
        $venues = Venue::all();
        return view('admin.venue.index', compact('venues'));
    }

    public function create()
    {
        return view('admin.venue.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_venue' => 'required',
            'alamat' => 'required',
            'kapasitas' => 'required|integer',
        ]);

        Venue::create($request->all());
        return redirect()->route('admin.venue.index')->with('success', 'Venue berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $venue = Venue::findOrFail($id);
        return view('admin.venue.edit', compact('venue'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_venue' => 'required',
            'alamat' => 'required',
            'kapasitas' => 'required|integer',
        ]);

        $venue = Venue::findOrFail($id);
        $venue->update($request->all());

        return redirect()->route('admin.venue.index')->with('success', 'Venue berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete(); // Karena sudah pakai SoftDeletes di Model, ini otomatis mengisi deleted_at

        return redirect()->route('admin.venue.index')->with('success', 'Venue berhasil dipindahkan ke kotak sampah!');
    }

    /**
     * FITUR BARU: Menampilkan data yang dihapus (Trash)
     */
    public function trash()
    {
        $venues = Venue::onlyTrashed()->get();
        return view('admin.venue.trash', compact('venues'));
    }

    /**
     * FITUR BARU: Mengembalikan data (Restore)
     */
    public function restore($id)
    {
        $venue = Venue::withTrashed()->findOrFail($id);
        $venue->restore();

        return redirect()->route('admin.venue.trash')->with('success', 'Venue berhasil dipulihkan!');
    }

    /**
     * FITUR BARU: Hapus Permanen (Opsional)
     */
    public function forceDelete($id)
    {
        $venue = Venue::withTrashed()->findOrFail($id);
        $venue->forceDelete();

        return redirect()->route('admin.venue.trash')->with('success', 'Venue dihapus secara permanen!');
    }
}