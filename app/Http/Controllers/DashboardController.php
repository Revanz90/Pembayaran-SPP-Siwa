<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function hitungsurat()
    {
        return view('dashboard');
        // $anggota = Anggota::count();
        // $simpanan = Simpanan::count();
        // $pinjaman = Pinjamans::count();
        // $angsuran = Angsuran::count();

        // $credit = Credit::where('status_credit', 'diterima')->get()->count();

        // return view('dashboard', ['countmember' => $anggota, 'countsaving' => $simpanan, 'countcredit' => $pinjaman, 'countinstalment' => $angsuran]);
    }
}
