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
    Schema::create('voucher', function (Blueprint $table) {
        $table->id('id_voucher'); // Ini otomatis menjadi Unsigned Big Integer
        $table->string('kode_voucher', 20);
        $table->integer('potongan');
        $table->integer('kuota');
        $table->enum('status', ['aktif', 'nonaktif']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher');
    }
};
