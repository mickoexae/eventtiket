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
    Schema::create('tikets', function (Blueprint $table) {
        $table->id('id_tiket');
        
        // Gunakan cara ini agar tipe datanya dipastikan Unsigned Big Integer
        $table->unsignedBigInteger('id_event');
        $table->foreign('id_event')
              ->references('id_event')
              ->on('events')
              ->onDelete('cascade');

        $table->string('nama_tiket'); 
        $table->integer('harga');
        $table->integer('stok');
        $table->timestamps();
    });
}

public function down(): void
{
    // Pastikan nama tabelnya 'tikets' (pakai 's'), tadi di kode kamu 'tiket'
    Schema::dropIfExists('tikets');
}
};
