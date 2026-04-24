<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    // 1. Sesuaikan nama tabel (Cek phpMyAdmin, kalau 'tiket' ya tulis 'tiket')
    protected $table = 'tikets'; 

    protected $primaryKey = 'id_tiket';

    // 2. JANGAN LUPA: Cek di phpMyAdmin kolom stok kamu namanya apa?
    // Kalau namanya 'stok', nanti di Controller kita ganti jadi 'stok'.
    protected $fillable = [
        'id_event',
        'nama_tiket',
        'harga',
        'stok', // <--- GANTI INI kalau di database namanya 'stok' atau lainnya
    ];

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }
}