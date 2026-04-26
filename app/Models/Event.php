<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Tambahkan Import ini

class Event extends Model
{
    use HasFactory, SoftDeletes; // 2. Tambahkan SoftDeletes di sini

    protected $table = 'events';
    protected $primaryKey = 'id_event';

    protected $fillable = [
        'nama_event',
        'foto',   
        'tanggal_event', 
        'tanggal', 
        'id_venue',
    ];

    /**
     * Relasi ke tabel Venue
     * Ditambahkan withTrashed() agar jika Venue di-soft-delete,
     * Event tetap bisa menampilkan info venuenya (misal: "Venue telah dihapus").
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'id_venue')->withTrashed();
    }

    public function tikets() 
    {
        return $this->hasMany(Tiket::class, 'id_event', 'id_event');
    }
}