<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nisn',
        'nama_lengkap',
        'kelas',
        'jurusan',
        'tahun_masuk',
        'alamat_siswa',
        'user_id',
        // Add other fields as needed
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
