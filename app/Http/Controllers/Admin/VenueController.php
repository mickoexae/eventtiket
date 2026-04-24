<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $venues = \App\Models\Venue::all();
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

    \App\Models\Venue::create($request->all());

    return redirect()->route('admin.venue.index')->with('success', 'Venue berhasil ditambahkan!');
}

public function edit($id)
{
    // Cari data venue berdasarkan id_venue
    $venue = \App\Models\Venue::findOrFail($id);
    return view('admin.venue.edit', compact('venue'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_venue' => 'required',
        'alamat' => 'required',
        'kapasitas' => 'required|integer',
    ]);

    $venue = \App\Models\Venue::findOrFail($id);
    $venue->update($request->all());

    return redirect()->route('admin.venue.index')->with('success', 'Venue berhasil diperbarui!');
}

public function destroy($id)
{
    $venue = \App\Models\Venue::findOrFail($id);
    $venue->delete();

    return redirect()->route('admin.venue.index')->with('success', 'Venue berhasil dihapus!');
}
}
