<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'voucher'; // Sesuai ERD
    protected $primaryKey = 'id_voucher';// Sesuai ERD

    protected $fillable = [
    'kode_voucher',
    'potongan',
    'kuota', 
    'status'
];
}