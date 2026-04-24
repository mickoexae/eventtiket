<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('order_detail', function (Blueprint $table) {
        $table->id('id_order_detail');
        
        // Relasi ke tabel orders (pastikan nama tabelnya 'orders' atau 'order')
        $table->unsignedBigInteger('id_order');
        $table->foreign('id_order')->references('id_order')->on('orders')->onDelete('cascade');

        // PERBAIKAN DI SINI: Harus mengarah ke 'tikets' (pakai 's')
        $table->unsignedBigInteger('id_tiket');
        $table->foreign('id_tiket')->references('id_tiket')->on('tikets')->onDelete('cascade');

        $table->integer('jumlah');
        $table->integer('subtotal');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
