<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KartuSpp;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanSPPController extends Controller
{
    public function index(Request $request) {
        // Initialize the query
        $query = KartuSpp::with('siswa', 'penerimapembayaranspp');

        // Apply date range filter if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->whereBetween('setoran_untuk_bulan', [$startDate, $endDate]);
        }

        // Apply jurusan filter if provided
        if ($request->filled('jurusan')) {
            $jurusan = $request->input('jurusan');
            $query->whereHas('siswa', function ($q) use ($jurusan) {
                $q->where('jurusan', $jurusan);
            });
        }

        // Apply kelas filter if provided
        if ($request->filled('kelas')) {
            $kelas = $request->input('kelas');
            $query->whereHas('siswa', function ($q) use ($kelas) {
                $q->where('kelas', $kelas);
            });
        }

        // Apply status filter if provided
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('status_setoran', $status);
        }

        // Get the filtered results
        $kartuSpps = $query->get();

         // Calculate the sum of nilai setoran
        $totalNilaiSetoran = $kartuSpps->sum('nilai_setoran');

        // Count the status
        $countBelumBayar = $kartuSpps->where('status_setoran', 'belum dibayar')->count();
        $countSudahTransfer = $kartuSpps->where('status_setoran', 'sudah ditransfer')->count();
        $countDiterimaBendahara = $kartuSpps->where('status_setoran', 'diterima bendahara')->count();

        // Prepare the response data
        $response = [
            'kartuSpps' => $kartuSpps,
            'totalNilaiSetoran' => $totalNilaiSetoran,
            'countBelumBayar' => $countBelumBayar,
            'countSudahTransfer' => $countSudahTransfer,
            'countDiterimaBendahara' => $countDiterimaBendahara,
        ];

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json($response);
        } else {
            // Return view for non-AJAX requests
            return view('layouts.menu.laporan-spp',  $response);
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
