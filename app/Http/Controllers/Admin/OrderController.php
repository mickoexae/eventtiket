<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Attendee;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi (Admin)
     */
    public function index()
    {
        $orders = Order::with(['user', 'details.tiket'])->latest()->get();
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu transaksi tertentu
     */
    public function show($id)
    {
        $order = Order::with(['user', 'details.tiket'])->findOrFail($id);
        return view('admin.order.show', compact('order'));
    }

    /**
     * Menghapus riwayat transaksi
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.order.index')->with('success', 'Riwayat transaksi berhasil dihapus!');
    }

    /**
     * Halaman Scanner QR Code
     */
    public function scanner()
    {
        // Menggunakan kolom 'status_kehadiran' sesuai struktur database kamu
        $sudahHadir = Attendee::where('status_kehadiran', 'sudah_hadir')->count();
        $belumHadir = Attendee::where('status_kehadiran', 'belum_hadir')->count();
        
        return view('admin.order.scanner', compact('sudahHadir', 'belumHadir'));
    }

    /**
     * Memproses QR Code dari scanner
     */
    public function cekTiket(Request $request)
    {
        // Jika request datang dari AJAX (scanner kamera), kita handle secara JSON
        $kode = $request->kode_tiket;

        if (!$kode) {
            $msg = 'Kode tiket tidak boleh kosong!';
            return $request->expectsJson() 
                ? response()->json(['success' => false, 'message' => $msg]) 
                : back()->with('error', $msg);
        }

        // PERBAIKAN: Hanya cari di kolom 'qr_code'
        $peserta = Attendee::where('qr_code', $kode)->first();

        if (!$peserta) {
            $msg = 'Tiket tidak ditemukan!';
            return $request->expectsJson() 
                ? response()->json(['success' => false, 'message' => $msg]) 
                : back()->with('error', $msg);
        }

        if ($peserta->status_kehadiran === 'sudah_hadir') {
            $msg = 'Tiket ini sudah pernah di-scan sebelumnya!';
            return $request->expectsJson() 
                ? response()->json(['success' => false, 'message' => $msg]) 
                : back()->with('error', $msg);
        }

        // Update status kehadiran ke 'sudah_hadir'
        $peserta->update(['status_kehadiran' => 'sudah_hadir']);

        $msg = 'Berhasil Check-in! Selamat datang, ' . ($peserta->nama_peserta ?? 'Peserta');
        return $request->expectsJson() 
            ? response()->json(['success' => true, 'message' => $msg]) 
            : back()->with('success', $msg);
    }

    /**
     * Laporan Kehadiran Peserta
     */
    public function laporanKehadiran(Request $request)
    {
        $search = $request->get('search');

        // PERBAIKAN: Cari berdasarkan 'qr_code' atau 'nama_peserta'
        $attendees = Attendee::when($search, function ($query) use ($search) {
                return $query->where('qr_code', 'like', "%{$search}%")
                             ->orWhere('nama_peserta', 'like', "%{$search}%")
                             ->orWhere('status_kehadiran', 'like', "%{$search}%");
            })
            ->orderBy('status_kehadiran', 'desc')
            ->latest('updated_at')
            ->paginate(20);

        return view('admin.attendee.index', compact('attendees'));
    }
}