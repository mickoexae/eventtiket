<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Tiket;
use App\Models\Attendee; // Pastikan Model ini ada
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Menyimpan transaksi dan membuat data attendee otomatis.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        DB::beginTransaction();
        try {
            $totalBayar = $request->input('total_akhir', 0);

            $order = Order::create([
                'id_user'       => Auth::id(),
                'tanggal_order' => now(),
                'total'         => $totalBayar, 
                'status'        => 'paid',
                'id_voucher'    => $request->input('id_voucher'), 
            ]);

            if ($request->has('jumlah')) {
                foreach ($request->jumlah as $id_tiket => $qty) {
                    if ($qty > 0) {
                        $tiket = Tiket::find($id_tiket);
                        if ($tiket) {
                            $detail = OrderDetail::create([
                                'id_order' => $order->id_order,
                                'id_tiket' => $id_tiket,
                                'jumlah'   => $qty,
                                'subtotal' => $tiket->harga * $qty,
                            ]);

                            // Loop untuk membuat e-tiket (attendee) sesuai jumlah beli
                            for ($i = 0; $i < $qty; $i++) {
                                Attendee::create([
                                    'id_order_detail'  => $detail->id_order_detail,
                                    'nama_peserta'     => Auth::user()->name ?? 'Pembeli', 
                                    'email_peserta'    => Auth::user()->email,
                                    'qr_code'          => 'TIX-' . strtoupper(Str::random(10)),
                                    'status_kehadiran' => 'belum_hadir', // Sesuai ENUM database kamu
                                ]);
                            }

                            $tiket->decrement(isset($tiket->kuota) ? 'kuota' : 'stok', $qty);
                        }
                    }
                }
            }

            if ($request->id_voucher) {
                Voucher::where('id_voucher', $request->id_voucher)->decrement('kuota', 1);
            }

            DB::commit();
            return redirect()->route('user.tiket_saya')->with('success', 'Transaksi Berhasil!');
        } catch (\Exception $e) {
            DB::rollback();
            return "Gagal simpan database: " . $e->getMessage();
        }
    }

    /**
     * Menampilkan daftar tiket dalam satu order.
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
     * Method tambahan untuk menangani penampilan satu E-Tiket (QR Code).
     * Ini untuk mengatasi error "Call to undefined method showEtiket"
     */
    public function showEtiket($qr_code)
{
    $attendee = Attendee::with('order_detail.tiket.event')
        ->where('qr_code', $qr_code)
        ->firstOrFail();

    // Ganti dari 'user.etiket_view' menjadi 'user.e_tiket_qr'
    return view('user.e_tiket_qr', compact('attendee'));
}
}