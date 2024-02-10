<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KartuSPP extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return view('layouts.menu.kartu-spp', ['siswas' => $siswa]);
    }
}
