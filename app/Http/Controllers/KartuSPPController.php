<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KartuSpp;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KartuSPPController extends Controller
{
    public function index()
    {
        // Get all students
        $siswas = Siswa::orderBy('created_at', 'desc')->get();

        // Check if a bill exists for each student for the current month
        $siswaId = collect($siswas->pluck("id")->toArray());
        $existingKartuSPPs = [];
        $startDate = now()->startOfYear()->addMonths(6);
        $currentDate = $startDate->copy();

        foreach ($siswaId as $id) {
            // Check if a bill for this month already exists for the student
            $existingKartuSPP = KartuSpp::where('id_siswa', $id)
                ->whereMonth('setoran_untuk_bulan', $currentDate->month)
                ->whereYear('setoran_untuk_bulan', $currentDate->year)
                ->exists();

            // Store the result in the array using the student ID as key
            $existingKartuSPPs[$id] = $existingKartuSPP;
        }

        // Pass the data to the view
        return view('layouts.menu.kartu-spp', [
            'siswas' => $siswas,
            'existingKartuSPPs' => $existingKartuSPPs
        ]);
    }

    public function terbitkanKartuSPP($id)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            $startDate = now()->startOfYear()->addMonths(6);
            $endDate = $startDate->copy()->addYear();

            $currentDate = $startDate->copy();
            while ($currentDate < $endDate) {
                // Check if a bill for this month already exists for the student
                $existingKartuSPP = KartuSpp::where('id_siswa', $id)
                    ->whereMonth('setoran_untuk_bulan', $currentDate->month)
                    ->whereYear('setoran_untuk_bulan', $currentDate->year)
                    ->exists();

                // If a bill doesn't exist, create one
                if (!$existingKartuSPP) {
                    // Add payment due date on the 10th of the month
                    $paymentDueDate = $currentDate->copy()->day(10);

                    KartuSpp::create([
                        'setoran_untuk_bulan' => $currentDate->format('Y-m-d'),
                        'tanggal_jatuh_tempo' => $paymentDueDate->format('Y-m-d'),
                        'id_siswa' => $id,
                    ]);
                }
                // Move to the next month
                $currentDate->addMonth();
            }
 
            // Commit the database transaction if everything is successful
            DB::commit();

            // Redirect with success message
            return redirect()->back()->with('success', 'Berhasil menerbitkan Kartu SPP.');
        } catch (\Throwable $th) {
            dd($th);
            // An error occurred, rollback the database transaction
            DB::rollback();

            // Redirect with error message
            return redirect()->back()->with('error', 'Gagal menerbitkan Kartu SPP.');
        }
        
    }

    public function generateKartuPDF()
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
            
                // Optional: Set the paper size and orientation
                // $pdf->setPaper('A4', 'landscape');

                // Render the view with the student data
                $pdf = PDF::loadView('pdf.kartu-spp', compact('siswa', 'kartuspp', 'existingKartuSPP'));

                // Return the PDF as a download
                return $pdf->download('Kartu SPP ' . $siswa->nama_lengkap . '.pdf');

                // return view('pdf.kartu-spp', [
                //     'siswa' => $siswa,
                //     'kartuspp' => $kartuspp,
                //     'existingKartuSPP' => true, // Set existingKartuSPP to true
                // ]);
            } else {
                // If KartuSPP does not exist, return a message or redirect
                return redirect()->back()->with('error', 'Kartu SPP for the current month does not exist.');
            }
        } else {
            // If the user is not authenticated, return a message or redirect
            return redirect()->back()->with('error', 'Unauthorized access.');
        } 
    }
}
