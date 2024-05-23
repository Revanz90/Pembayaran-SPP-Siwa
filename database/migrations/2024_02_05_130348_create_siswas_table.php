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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->integer('nisn');
            $table->string('nama_lengkap');
            $table->string('kelas');
            $table->enum('status_setoran', ['belum dibayar', 'sudah ditransfer', 'diterima bendahara'])->default('belum dibayar');
            $table->enum('jurusan', ['akuntasi', 'keperawatan', 'bisnis dan pemasaran']);
            $table->dateTime('tahun_masuk');
            $table->string('alamat_siswa');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
