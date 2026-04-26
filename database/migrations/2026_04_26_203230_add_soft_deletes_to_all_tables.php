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
    // Cek satu-satu, kalau nama tabel kamu 'venue' (tanpa s), hapus huruf 's' nya
    if (Schema::hasTable('venue')) {
        Schema::table('venue', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    if (Schema::hasTable('event')) {
        Schema::table('event', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    if (Schema::hasTable('tiket')) {
        Schema::table('tiket', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
}

public function down()
{
    // Jangan lupa bagian down agar bisa di-rollback
    Schema::table('venue', function (Blueprint $table) { $table->dropSoftDeletes(); });
    Schema::table('event', function (Blueprint $table) { $table->dropSoftDeletes(); });
    Schema::table('tiket', function (Blueprint $table) { $table->dropSoftDeletes(); });
}
};
