<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('venue')->get();
        return view('admin.event.index', compact('events'));
    }

    public function checkoutMultiple(Request $request)
    {
        $jumlahInput = $request->input('jumlah', []);
        $selectedTickets = [];
        $total_harga = 0;

        foreach ($jumlahInput as $id_tiket => $qty) {
            if ($qty > 0) {
                $tiket = Tiket::find($id_tiket);
                if ($tiket) {
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

        if (empty($selectedTickets)) {
            return redirect()->back()->with('error', 'Silakan pilih minimal 1 tiket sebelum checkout.');
        }

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
        $request->validate([
            'nama_event' => 'required',
            'id_venue' => 'required',
            'tanggal' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $event = new Event();
        $event->nama_event = $request->nama_event;
        $event->id_venue = $request->id_venue;
        $event->tanggal = $request->tanggal;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('storage/events'), $nama_file); 
            $event->foto = 'events/' . $nama_file;
        }

        $event->save();
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $event = Event::with('tikets')->findOrFail($id);
        $venues = Venue::all();
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
            if ($event->foto && file_exists(public_path('storage/' . $event->foto))) {
                unlink(public_path('storage/' . $event->foto));
            }

            $file = $request->file('foto');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('storage/events'), $nama_file); 
            $data['foto'] = 'events/' . $nama_file;
        }

        $event->update($data);

        // Hapus tiket lama secara permanen untuk diisi ulang (karena ini bagian dari update event)
        Tiket::where('id_event', $id)->forceDelete();

        if ($request->has('nama_tiket')) {
            foreach ($request->nama_tiket as $key => $val) {
                Tiket::create([
                    'id_event' => $event->id_event,
                    'nama_tiket' => $request->nama_tiket[$key],
                    'harga' => $request->harga_tiket[$key],
                    'stok' => $request->stok_tiket[$key], 
                ]);
            }
        }

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        // Soft Delete event (Tiket otomatis tersembunyi karena relasi)
        $event->delete();

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil dipindahkan ke kotak sampah!');
    }

    /**
     * FITUR TRASH
     */
    public function trash()
    {
        $events = Event::onlyTrashed()->with('venue')->get();
        return view('admin.event.trash', compact('events'));
    }

    public function restore($id)
    {
        $event = Event::withTrashed()->findOrFail($id);
        $event->restore();

        return redirect()->route('admin.event.trash')->with('success', 'Event berhasil dipulihkan!');
    }

    public function forceDelete($id)
    {
        $event = Event::withTrashed()->findOrFail($id);
        
        // Hapus file foto jika ada
        if ($event->foto && file_exists(public_path('storage/' . $event->foto))) {
            unlink(public_path('storage/' . $event->foto));
        }

        // Hapus permanen tiket terkait
        Tiket::where('id_event', $id)->forceDelete();
        
        $event->forceDelete();

        return redirect()->route('admin.event.trash')->with('success', 'Event dihapus permanen!');
    }
}