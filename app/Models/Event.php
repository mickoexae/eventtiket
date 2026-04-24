<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id_event';

    protected $fillable = [
    'nama_event',
    'foto',   
    'tanggal_event', 
    'tanggal', 
    'id_venue',
];

    // Relasi ke tabel Venue
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'id_venue');
    }

    public function tikets() {
    return $this->hasMany(Tiket::class, 'id_event', 'id_event');
}
}