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
        Schema::create('spp_payment_files', function (Blueprint $table) {
            $table->id();
            $table->string('bukti_transfer')->nullable();
            $table->unsignedBigInteger('bukti_pembayaran_spp_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_payment_files');
    }
};
