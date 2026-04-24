<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $table = 'orders'; 
    protected $primaryKey = 'id_order';
    protected $fillable = ['id_user', 'tanggal_order', 'total', 'status', 'id_voucher'];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke Voucher
    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'id_voucher', 'id_voucher');
    }

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }

    public function details(): HasMany
    {
        return $this->order_details();
    }
}