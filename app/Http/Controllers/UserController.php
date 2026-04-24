<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Tiket;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Halaman Cari Tiket (Menampilkan semua Event)
    public function cariTiket()
    {
        // Tetap pakai 'tikets' karena di Model Event fungsinya bernama 'tikets'
        $events = Event::with(['venue', 'tikets'])->get();
        
        return view('user.cari_tiket', compact('events'));
    }

    public function cekVoucher(Request $request)
{
    $kode = trim(strtoupper($request->kode));
    $voucher = \App\Models\Voucher::where('kode_voucher', $kode)
                ->where('status', 'aktif')
                ->where('kuota', '>', 0)
                ->first();

    if ($voucher) {
        return response()->json([
            'valid'      => true,
            'id_voucher' => $voucher->id_voucher, // <--- Ini harus dikirim
            'potongan'   => $voucher->potongan,
            'pesan'      => "Voucher berhasil digunakan!"
        ]);
    }

    return response()->json(['valid' => false, 'pesan' => "Kode voucher tidak valid"]);
}

    // Halaman Tiket Saya (Riwayat Order milik User tersebut)
    // app/Http/Controllers/UserController.php

public function tiketSaya()
{
    $orders = Order::where('id_user', Auth::id())
                // Hapus id_voucher dari sini, biarkan details.tiket saja
                ->with(['details.tiket']) 
                ->orderBy('tanggal_order', 'desc')
                ->get();
                
    return view('user.tiket_saya', compact('orders'));
}

    public function showEvent($id)
    {
        $event = Event::with(['venue', 'tikets'])->findOrFail($id);
        
        return view('user.detail_event', compact('event'));
    }

    public function checkout($id_tiket)
    {
        $tiket = Tiket::with('event')->findOrFail($id_tiket);
        
        return view('user.checkout', compact('tiket'));
    }
}