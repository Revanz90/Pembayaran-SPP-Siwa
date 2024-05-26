<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KartuSpp;
use App\Models\Siswa;
use App\Models\SppPayment;
use App\Models\SppPaymentFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function bayarTagihanSPP(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Validate the request data
            $request->validate([
                // 'tanggal_transfer' => 'required|date',
                'setoran_untuk_bulan' => 'required',
                'nominal' => 'required|numeric',
                'bukti_transfer' => 'required|file',
            ]);

            // Check if a file has been uploaded
            if ($request->hasFile('bukti_transfer')) {

                $userID = Auth::id();
                $siswaID = Siswa::where('user_id', $userID)->first();

                // Convert the date format to match MySQL format
                // $tanggal_transfer = Carbon::parse($request->tanggal_transfer)->toDateString();
                $tanggal_transfer = Carbon::now();

                // Fetch the data from the database
                $kartuSpp = KartuSpp::where('setoran_untuk_bulan', $request->setoran_untuk_bulan)
                    ->where('id_siswa', $siswaID->id)
                    ->first();

                // Calculate the number of days late
                $dueDate = Carbon::parse($kartuSpp->tanggal_jatuh_tempo);
                $daysLate = $dueDate->diffInDays($tanggal_transfer, false);

                // Update KartuSPP with the provided data
                KartuSpp::where('setoran_untuk_bulan', $request->setoran_untuk_bulan)
                        ->where('id_siswa', $siswaID->id)
                        ->update([
                            'tanggal_transfer' => $tanggal_transfer,
                            'nilai_setoran' => $request->nominal,
                            'status_setoran' => 'sudah ditransfer',
                            'jumlah_hari_terlambat' => $daysLate
                ]);

                // Store the data in the database
                $buktiPembayaran = SppPayment::create([
                    'tanggal_transfer' => $tanggal_transfer,
                    'setoran_untuk_bulan' => $request->setoran_untuk_bulan,
                    'nilai_setoran' => $request->nominal,
                    'id_kartu_spp' => $kartuSpp->id,
                    'id_siswa' => $siswaID->id,
                ]);

                // Store the file and get its path
                $directory = 'filepayment';
                $uploadedFile = $request->file('bukti_transfer');
                $pathFile = Storage::disk('public')->put($directory, $uploadedFile);

                SppPaymentFile::create([
                    'bukti_transfer' => $pathFile, 
                    'bukti_pembayaran_spp_id' => $buktiPembayaran->id
                ]);

                // Commit the database transaction
                DB::commit();

                // Redirect back or to a specific route
                return redirect()->back()->with('success', 'Berhasil menambahkan Bukti Pembayaran.');
            } else {
                // Handle the case where no file has been uploaded
                return redirect()->back()->with('error', 'Gagal karena File bukti pembayaran tidak ada.');
            }
        } catch (\Exception $e) {
            // Rollback the database transaction if an exception occurs
            DB::rollback();

            // For now, we'll just return an error message
            return redirect()->back()->with('error', 'Failed to store data: ' . $e->getMessage());
        }
    }
}
