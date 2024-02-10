<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataSiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return view('layouts.menu.data_siswa', ['siswas' => $siswa]);
    }

    public function create(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Validate the request data
            $request->validate([
                'nisn' => 'required',
                'nama_siswa' => 'required',
                'optionKelas' => 'required',
                'jurusan' => 'required',
                'alamat_siswa' => 'required',
                'email_siswa' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8'
            ]);

            // Create the user
            $user = User::create([
                'name' => $request->nama_siswa,
                'email' => $request->email_siswa,
                'password' => bcrypt($request->password),
            ]);

            // Sync roles for the user
            $user->assignRole('siswa');

            // Create siswa
            Siswa::create([
                'nisn' => $request->nisn,
                'nama_lengkap' => $request->nama_siswa,
                'kelas' => $request->optionKelas,
                'jurusan' => $request->jurusan,
                'alamat_siswa' => $request->alamat_siswa,
                'user_id' => $user->id
            ]);

            // Commit the database transaction if everything is successful
            DB::commit();

            // Redirect with success message
            return redirect()->back()->with('success', 'Berhasil menambahkan Siswa.');
        } catch (\Exception $e) {
            // An error occurred, rollback the database transaction
            DB::rollback();

            // Redirect with error message
            return redirect()->back()->with('error', 'Gagal menambahkan Siswa.');
        }   
    }
}
