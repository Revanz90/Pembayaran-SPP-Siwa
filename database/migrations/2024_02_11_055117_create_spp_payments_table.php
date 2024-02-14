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
        Schema::create('spp_payments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_transfer')->nullable();
            $table->dateTime('setoran_untuk_bulan');
            $table->integer('nilai_setoran')->nullable();
            $table->unsignedBigInteger('id_kartu_spp');
            $table->unsignedBigInteger('id_siswa');
            $table->enum('status_setoran', ['ditransfer'])->default('ditransfer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_payments');
    }
};
