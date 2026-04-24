<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    // Pakai 'order_detail' (sesuai screenshot database kamu sebelumnya)
    protected $table = 'order_detail'; 

    protected $primaryKey = 'id_order_detail';

    protected $fillable = [
        'id_order',
        'id_tiket',
        'jumlah',
        'subtotal'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function attendees()
{
    // Sesuaikan foreign key-nya, misal 'id_order_detail'
    return $this->hasMany(Attendee::class, 'id_order_detail', 'id_order_detail');
}

public function tiket()
{
    // Relasi ke model Tiket
    return $this->belongsTo(Tiket::class, 'id_tiket', 'id_tiket');
}
}