<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\DashboardController;
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

// Route::middleware('auth')->group(function () {

//     Route::get('/data_simpanan', [SavingController::class, 'index'])->name('datasimpanan');

//     Route::get('/data_pinjaman', [CreditController::class, 'index'])->name('datapinjaman');

//     Route::get('/data_angsuran', [InstallmentController::class, 'index'])->name('dataangsuran');

//     Route::get('/data_anggota', [DataAnggotaController::class, 'index'])->name('dataanggota');
// });

require __DIR__ . '/auth.php';
