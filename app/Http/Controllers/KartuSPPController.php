<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KartuSpp;
use App\Models\Siswa;
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
                    KartuSpp::create([
                        'setoran_untuk_bulan' => $currentDate->format('Y-m-d'),
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
}
