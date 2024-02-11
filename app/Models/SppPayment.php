<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_transfer',
        'setoran_untuk_bulan',
        'nilai_setoran',
        'id_siswa'
        // Add other fields as needed
    ];
}
