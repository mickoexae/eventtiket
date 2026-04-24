<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id('id_order'); // Sesuai Tugas 20 [cite: 114]
        
        // Tipe data harus unsignedBigInteger agar cocok dengan $table->id()
        $table->unsignedBigInteger('id_user'); 
        
        $table->datetime('tanggal_order');
        $table->integer('total');
        $table->enum('status', ['pending', 'paid', 'cancel']); // Sesuai Tugas 14 [cite: 81]
        
        $table->unsignedBigInteger('id_voucher')->nullable();

        // PERBAIKAN DI SINI:
        // Ganti references('id') menjadi references('id_user')
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        
        // Pastikan juga voucher merujuk ke id_voucher
        $table->foreign('id_voucher')->references('id_voucher')->on('voucher')->onDelete('set null');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
