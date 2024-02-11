<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KartuSpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TerimaTagihanController extends Controller
{
    public function index(){
        $kartuspp = KartuSpp::whereIn('status_setoran', ['sudah ditransfer', 'diterima bendahara'])
            ->orderBy('status_setoran', 'asc') // Sort by status_setoran in descending order
            ->get();
        return view('layouts.menu.terima-tagihan-spp', ['kartuspp' => $kartuspp]);
    }

    public function terimaSPP($id){
        try {
            // Begin a database transaction
            DB::beginTransaction();

            KartuSpp::where('id', $id)
                ->update([
                    'status_setoran' => 'diterima bendahara',
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
