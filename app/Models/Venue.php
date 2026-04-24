<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $table = 'venue';
    protected $primaryKey = 'id_venue'; // Sangat penting!
    
    protected $fillable = [
        'nama_venue',
        'alamat',
        'kapasitas'
    ];
}