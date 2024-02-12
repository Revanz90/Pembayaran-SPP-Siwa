<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KartuSpp extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_transfer',
        'setoran_untuk_bulan',
        'nilai_setoran',
        'id_siswa',
        'status_setoran',
        // Add other fields as needed
    ];

    public function penerimapembayaranspp()
    {
        return $this->belongsTo(User::class, 'id_diterima_oleh');
    }
}
