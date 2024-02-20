<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KartuSpp;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanSPPController extends Controller
{
    public function index(Request $request) {
        // Get start and end dates from the request
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->startOfDay();

        // Format the dates as needed for comparison
        $formattedStartDate = $startDate->toDateTimeString();
        $formattedEndDate = $endDate->toDateTimeString();

        // If start and end dates are provided, fetch records for that date range
        if ($startDate && $endDate) {
            // DB::enableQueryLog();

            $kartuSpps = KartuSpp::with('siswa')
                ->where('status_setoran', 'diterima bendahara')
                ->whereBetween('setoran_untuk_bulan', [$formattedStartDate, $formattedEndDate])
                ->get();
            // $queries = DB::getQueryLog();
            // dd($queries);
        } else {
            // If no date range provided, fetch all records
            $kartuSpps = KartuSpp::with('siswa')
                ->where('status_setoran', 'diterima bendahara')
                ->get();
        }
    
        return view('layouts.menu.laporan-spp', ['kartuSpps' => $kartuSpps]);
    }
        
}
