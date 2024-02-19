<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KartuSpp;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanSPPController extends Controller
{
    public function index(Request $request) {
        // Get the start and end dates from the date range picker
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        // Format the dates as needed for comparison
        $formattedStartDate = $startDate->toDateTimeString();
        $formattedEndDate = $endDate->toDateTimeString();
        
        
        // If start and end dates are provided, fetch records for that date range
        if ($startDate && $endDate) {
            $kartuSpps = KartuSpp::with('siswa')
                ->where('status_setoran', 'diterima bendahara')
                ->whereBetween('setoran_untuk_bulan', [$formattedStartDate, $formattedEndDate])
                ->get();
            dd($kartuSpps);
        } else {
            // If no date range provided, fetch all records
            $kartuSpps = KartuSpp::with('siswa')
                ->where('status_setoran', 'diterima bendahara')
                ->get();
        }
    
        return view('layouts.menu.laporan-spp', ['kartuSpps' => $kartuSpps]);
    }
        
    // public function index($date = null){
    //     if ($date === null) {
    //         $kartuSpps = KartuSpp::with('siswa')->where('status_setoran', 'diterima bendahara')->get();
    
    //         return view('layouts.menu.laporan-spp', ['kartuSpps' => $kartuSpps]);
    //     } else {
    //         // If $date is not null, fetch records for that specific date range
    //         $kartuSpps = KartuSpp::with('siswa')
    //             ->where('status_setoran', 'diterima bendahara')
    //             ->whereBetween('setoran_untuk_bulan', [$startDate, $endDate])
    //             ->get();

    //         return view('layouts.menu.laporan-spp', ['kartuSpps' => $kartuSpps]);
    //     }
    // }
}
