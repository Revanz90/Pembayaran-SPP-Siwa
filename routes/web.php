<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\KartuSPP;
use App\Http\Controllers\KartuSPPController;
use App\Http\Controllers\TagihanSPP;
use App\Http\Controllers\TagihanSPPController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/dashboard', [DashboardController::class, 'hitungsurat'], function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return view('auth.login');
});

Route::get('akun', [AkunController::class, 'akun'])->name('akun');

Route::middleware('auth')->group(function () {

    Route::get('/data_siswa', [DataSiswaController::class, 'index'])->name('datasiswa');
    Route::post('/data_siswa', [DataSiswaController::class, 'create'])->name('create.datasiswa');

    Route::get('/kartu-spp', [KartuSPPController::class, 'index'])->name('kartu.spp');
    Route::post('/kartu-spp/{id}', [KartuSPPController::class, 'terbitkanKartuSPP'])->name('terbitkan.kartu.spp');

    Route::get('/tagihan-spp', [TagihanSPPController::class, 'index'])->name('tagihan.spp');
    Route::post('/tagihan-spp', [TagihanSPPController::class, 'bayarTagihanSPP'])->name('bayar.tagihan.spp');
    // Route::get('/data_pinjaman', [CreditController::class, 'index'])->name('datapinjaman');

    // Route::get('/data_angsuran', [InstallmentController::class, 'index'])->name('dataangsuran');

    // Route::get('/data_anggota', [DataAnggotaController::class, 'index'])->name('dataanggota');
});

require __DIR__ . '/auth.php';
