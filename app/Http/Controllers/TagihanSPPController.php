<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KartuSpp;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanSPPController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $userID = Auth::id();
            $siswa = Siswa::where('user_id', $userID)->first();
            
            $kartuspp = KartuSpp::where('id_siswa', $siswa->id)->get();
            return view('layouts.menu.tagihan-spp',['siswa' => $siswa, 'kartu' => $kartuspp]);
        }     
    }
}
