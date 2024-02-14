<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KartuSpp;
use App\Models\SppPayment;
use App\Models\SppPaymentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TerimaTagihanController extends Controller
{
    public function index(){
        $kartuspp = KartuSpp::whereIn('status_setoran', ['sudah ditransfer', 'diterima bendahara'])
            ->orderBy('status_setoran', 'asc') // Sort by status_setoran in descending order
            ->orderBy('tanggal_transfer', 'desc') // Then sort by tanggal_transfer in ascending order
            ->get();
        return view('layouts.menu.terima-tagihan-spp', ['kartuspp' => $kartuspp]);
    }

    public function detailBuktiTransferTagihan($id)
    {
        // Find the SPP payment ID associated with the given id_kartu_spp
        $sppPaymentId = SppPayment::where('id_kartu_spp', $id)->value('id');

        // Fetch the detailed data for the specific SPP payment with the found ID
        $detailSppPayment = SppPayment::findOrFail($sppPaymentId);
        
        // Fetch the associated files for the specific SPP payment
        $paymentFiles = SppPaymentFile::where('bukti_pembayaran_spp_id', $sppPaymentId)->get();
        
        // Return the detailed data including the payment and its associated files in JSON format
        return response()->json([
            'spp_payment' => $detailSppPayment,
            'payment_files' => $paymentFiles
        ]);
    }

    public function terimaSPP($id){
        try {
            // Begin a database transaction
            DB::beginTransaction();

            $userID = Auth::id();

            KartuSpp::where('id', $id)
                ->update([
                    'status_setoran' => 'diterima bendahara',
                    'id_diterima_oleh' => $userID
            ]);
 
            // Commit the database transaction if everything is successful
            DB::commit();

            // Redirect with success message
            return redirect()->back()->with('success', 'Berhasil menerbitkan Kartu SPP.');
        } catch (\Throwable $th) {
            // An error occurred, rollback the database transaction
            DB::rollback();

            // Redirect with error message
            return redirect()->back()->with('error', 'Gagal menerbitkan Kartu SPP.');
        }
    }
}
