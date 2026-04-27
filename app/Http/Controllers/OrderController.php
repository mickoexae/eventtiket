<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Tiket;
use App\Models\Attendee;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Langkah 1: Simpan Order dengan status 'pending'
     */
    public function store(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        DB::beginTransaction();
        try {
            $totalBayar = $request->input('total_akhir', 0);

            // Simpan data order awal dengan status PENDING
            $order = Order::create([
                'id_user'       => Auth::id(),
                'tanggal_order' => now(),
                'total'         => $totalBayar, 
                'status'        => 'pending', 
                'id_voucher'    => $request->input('id_voucher'), 
            ]);

            if ($request->has('jumlah')) {
                foreach ($request->jumlah as $id_tiket => $qty) {
                    if ($qty > 0) {
                        $tiket = Tiket::find($id_tiket);
                        if ($tiket) {
                            OrderDetail::create([
                                'id_order' => $order->id_order,
                                'id_tiket' => $id_tiket,
                                'jumlah'   => $qty,
                                'subtotal' => $tiket->harga * $qty,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            
            return redirect()->route('user.order.detail', $order->id_order)
                             ->with('success', 'Pesanan dibuat, silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            return "Gagal simpan database: " . $e->getMessage();
        }
    }

    /**
     * Langkah 2: Proses Bayar (Ubah Pending ke Paid & Kurangi Stok)
     */
    public function bayar($id)
    {
        DB::beginTransaction();
        try {
            // Gunakan where id_order untuk memastikan pencarian kolom yang benar
            $order = Order::with('order_details.tiket')->where('id_order', $id)->firstOrFail();

            if ($order->status !== 'pending') {
                return redirect()->back()->with('error', 'Pesanan ini sudah dibayar atau dibatalkan.');
            }

            // Update status menjadi PAID
            $order->update(['status' => 'paid']);

            // Ambil data user yang sedang login
            $user = Auth::user();

            // Proses pembuatan E-Tiket dan pengurangan STOK
            foreach ($order->order_details as $detail) {
                $tiket = $detail->tiket;
                
                for ($i = 0; $i < $detail->jumlah; $i++) {
                    Attendee::create([
                        'id_order_detail'  => $detail->id_order_detail,
                        // FIX: Gunakan ?? untuk mencegah nilai NULL yang bikin error database
                        'nama_peserta'     => $user->name ?? $user->email, 
                        'email_peserta'    => $user->email,
                        'qr_code'          => 'TIX-' . strtoupper(Str::random(10)),
                        'status_kehadiran' => 'belum_hadir',
                    ]);
                }

                // Kurangi stok tiket
                $tiket->decrement(isset($tiket->kuota) ? 'kuota' : 'stok', $detail->jumlah);
            }

            // Kurangi kuota voucher jika ada
            if ($order->id_voucher) {
                Voucher::where('id_voucher', $order->id_voucher)->decrement('kuota', 1);
            }

            DB::commit();
            return redirect()->route('user.tiket_saya')->with('success', 'Pembayaran Berhasil! E-Tiket telah terbit.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman detail order (Pending/Paid)
     */
    public function show($id)
    {
        $order = Order::with([
            'order_details.tiket.event', 
            'order_details.attendees'
        ])->where('id_order', $id)->firstOrFail();

        return view('user.order_detail', compact('order'));
    }

    /**
     * Menampilkan QR Code E-Tiket
     */
    public function showEtiket($qr_code)
    {
        $attendee = Attendee::with('order_detail.tiket.event')
            ->where('qr_code', $qr_code)
            ->firstOrFail();

        return view('user.e_tiket_qr', compact('attendee'));
    }
}