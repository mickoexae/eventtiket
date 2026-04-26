<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambah ini

class Tiket extends Model
{
    use SoftDeletes; // Pakai di sini

    protected $table = 'tikets'; 
    protected $primaryKey = 'id_tiket';

    protected $fillable = [
        'id_event',
        'nama_tiket',
        'harga',
        'stok',
    ];

    public function event()
    {
        // Ganti ke withTrashed() agar jika event dihapus, tiket tetap bisa akses namanya
        return $this->belongsTo(Event::class, 'id_event')->withTrashed();
    }
}