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
    Schema::create('attendee', function (Blueprint $table) {
        $table->id('id_attendee');
        
        // Sesuaikan dengan nama PK di tabel order_detail
        $table->unsignedBigInteger('id_order_detail'); 
        $table->foreign('id_order_detail')
              ->references('id_order_detail') // Harus sama dengan PK di order_detail
              ->on('order_detail')
              ->onDelete('cascade');

        $table->string('nama_peserta');
        $table->string('email_peserta');
        $table->string('qr_code')->unique();
        $table->enum('status_kehadiran', ['belum_hadir', 'sudah_hadir'])->default('belum_hadir');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendee');
    }
};
