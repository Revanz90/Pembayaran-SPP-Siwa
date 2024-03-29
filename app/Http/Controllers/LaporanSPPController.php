<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KartuSpp;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanSPPController extends Controller
{
    public function index(Request $request) {
        // Get start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // If start and end dates are provided, fetch records for that date range
        if ($startDate && $endDate) {
            // Convert the date strings to Carbon instances
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
    
            $kartuSpps = KartuSpp::with('siswa', 'penerimapembayaranspp')
                ->where('status_setoran', 'diterima bendahara')
                ->whereBetween('setoran_untuk_bulan', [$startDate, $endDate])
                ->get();
            
            if ($request->ajax()) {
                return response()->json($kartuSpps);
            } else {
                return view('layouts.menu.laporan-spp', ['kartuSpps' => $kartuSpps]);
            }
        } else {
            // If no date range provided, fetch all records
            $kartuSpps = KartuSpp::with('siswa')
                ->where('status_setoran', 'diterima bendahara')
                ->get();
            
            return view('layouts.menu.laporan-spp', ['kartuSpps' => $kartuSpps]);
        }
    }
    
    public function generateLaporanSPPPDF(Request $request){
        // Get start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch records based on the provided date range
        $kartuSpps = KartuSpp::with('siswa', 'penerimapembayaranspp')
            ->where('status_setoran', 'diterima bendahara')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('setoran_untuk_bulan', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
            })->get();

        // Render the PDF view with the fetched data
        $pdf = PDF::loadView('pdf.laporan-spp', compact('kartuSpps', 'startDate', 'endDate'));

        // Download the PDF file
        return $pdf->download('Laporan SPP'.$startDate.'-'.$endDate.'.pdf');

        // return view('pdf.laporan-spp', [
        //     'kartuSpps' => $kartuSpps, // Corrected variable name
        //     'startDate' => $startDate,
        //     'endDate' => $endDate,
        // ]);        
    }
}
