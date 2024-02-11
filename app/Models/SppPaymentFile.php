<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppPaymentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'bukti_transfer',
        'bukti_pembayaran_spp_id',
        // Add other fields as needed
    ];
}
