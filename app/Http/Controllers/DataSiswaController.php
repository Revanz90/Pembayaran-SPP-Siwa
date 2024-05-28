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
        $siswa = Siswa::orderBy('created_at', 'desc')->get();
        return view('layouts.menu.data_siswa', ['siswas' => $siswa]);
    }

    public function indexUpdate($id)
    {
        $siswa = Siswa::with('user')->find($id);
        return view('layouts.menu.edit_data_siswa', ['siswas' => $siswa]);
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
                'optionJurusan' => 'required',
                'tahun_masuk' => 'required',
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
                'jurusan' => $request->optionJurusan,
                'tahun_masuk' => $request->tahun_masuk,
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

    public function update(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Validate the request data
            $request->validate([
                'nisn' => 'required',
                'nama_siswa' => 'required',
                'optionKelas' => 'required',
                'optionJurusan' => 'required',
                'tahun_masuk' => 'required',
                'alamat_siswa' => 'required',
                'email_siswa' => 'required|email',
                'password' => 'required|string|min:8'
            ]);

            $user = User::findOrFail($request->user_id);
            $siswa = Siswa::find($request->siswa_id);

            $user->name = $request->nama_siswa;
            $user->email = $request->email_siswa;
            $user->password = bcrypt($request->password);
            $user->save();

            $siswa->nisn = $request->input('nisn');
            $siswa->nama_lengkap = $request->input('nama_siswa');
            $siswa->kelas = $request->input('optionKelas');
            $siswa->jurusan = $request->input('optionJurusan');
            $siswa->tahun_masuk = $request->input('tahun_masuk');
            $siswa->alamat_siswa = $request->input('alamat_siswa');
            $siswa->user_id = $request->user_id;
            $siswa->save();

            // Commit the database transaction if everything is successful
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil merubah siswa');
        } catch (\Throwable $th) {
            dd($th);
            // An error occurred, rollback the database transaction
            DB::rollback();
            
            return redirect()->back()->with('error', 'Gagal merubah siswa');
        }
    }
}
