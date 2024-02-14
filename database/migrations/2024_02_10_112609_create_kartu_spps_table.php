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
        Schema::create('kartu_spps', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_transfer')->nullable();
            $table->dateTime('setoran_untuk_bulan');
            $table->dateTime('tanggal_jatuh_tempo');
            $table->integer('jumlah_hari_terlambat')->nullable();
            $table->integer('nilai_setoran')->nullable();
            $table->unsignedBigInteger('id_siswa');
            $table->enum('status_setoran', ['belum dibayar', 'sudah ditransfer', 'diterima bendahara'])->default('belum dibayar');
            $table->unsignedBigInteger('id_diterima_oleh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_spps');
    }
};
