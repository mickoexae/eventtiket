<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambah ini

class Venue extends Model
{
    use HasFactory, SoftDeletes; // Pakai di sini

    protected $table = 'venue'; // Tetap biarkan 'venue' sesuai database kamu
    protected $primaryKey = 'id_venue';
    
    protected $fillable = [
        'nama_venue',
        'alamat',
        'kapasitas'
    ];
}