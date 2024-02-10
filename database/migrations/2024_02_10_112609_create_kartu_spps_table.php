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
            $table->integer('nilai_setoran')->nullable();
            $table->unsignedBigInteger('id_siswa');
            $table->enum('status_setoran', ['belum diterima','diterima'])->default('belum diterima');
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
