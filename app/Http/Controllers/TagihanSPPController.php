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

            $startDate = now()->startOfYear()->addMonths(6);
            $currentDate = $startDate->copy();

            // Check if a bill for this month already exists for the student
            $existingKartuSPP = KartuSpp::where('id_siswa', $siswa->id)
                ->whereMonth('setoran_untuk_bulan', $currentDate->month)
                ->whereYear('setoran_untuk_bulan', $currentDate->year)
                ->exists();

            if ($existingKartuSPP) {
                // If KartuSPP exists, fetch it
                $kartuspp = KartuSpp::where('id_siswa', $siswa->id)->get();
            
                return view('layouts.menu.tagihan-spp', [
                    'siswa' => $siswa,
                    'kartu' => $kartuspp,
                    'existingKartuSPP' => true, // Set existingKartuSPP to true
                ]);
            } else {
                return view('layouts.menu.tagihan-spp', [
                    'siswa' => $siswa,
                    'existingKartuSPP' => false, // Set existingKartuSPP to false
                ]);
            }
        }     
    }
}
