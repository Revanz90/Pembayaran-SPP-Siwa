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
        'alamat_siswa',
        'user_id',
        // Add other fields as needed
    ];
}
