<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    // Nama tabel di database (pastikan sudah benar)
    protected $table = 'attendee'; 

    // Primary Key tabel kamu
    protected $primaryKey = 'id_attendee';

    // WAJIB: Daftarkan kolom yang boleh diisi manual
    protected $fillable = [
        'id_order_detail',
        'nama_peserta',
        'email_peserta',
        'qr_code',
        'status_kehadiran',
    ];

    // Relasi ke OrderDetail (Opsional, tapi bagus buat nanti)
    public function order_detail()
    {
        return $this->belongsTo(OrderDetail::class, 'id_order_detail', 'id_order_detail');
    }
}