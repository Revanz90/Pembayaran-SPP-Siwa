<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanSPP extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $userID = Auth::id();

            $siswa = Siswa::where('user_id', $userID)->first();
            return view('layouts.menu.tagihan-spp',['siswa' => $siswa]);
        }     
    }
}
