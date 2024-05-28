@extends('main')

@section('title', 'Detail Data Siswa')
@section('title2', 'Detail Data Siswa')
@section('judul', 'Detail Data Siswa')

@section('content')
    <div id="xtest" style="font-size: 14px"></div>
    <div class="callout callout-warning">
        <i class="fas fa-info-circle"></i>
        Halaman untuk merubah data Siswa
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title font-weight-bold">DATA SISWA</h4>
            <div class="card-tools">
                <input type="hidden" name="statusM" id="statusMid[2]" value="2">
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('update.datasiswa') }}" enctype="multipart/form-data" method="POST" class="form-horizontal" id="ubahanggotaform">
            {{ csrf_field() }}
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">NISN</label>
                    <div class="col-sm-10">
                        <input type="number" name="nisn" class="form-control" id="nisn" value="{{ $siswas->nisn }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_siswa" class="form-control" id="nama_siswa" value="{{ $siswas->nama_lengkap }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Kelas Siswa</label>
                    <div class="col-sm-10">
                        <input type="radio" id="kelas-x" name="optionKelas" value="X">
                            <label>Kelas X</label><br>
                        <input type="radio" id="kelas-xi" name="optionKelas" value="XI">
                            <label>Kelas XI</label><br>
                        <input type="radio" id="kelas-xii" name="optionKelas" value="XII">
                            <label>Kelas XII</label><br>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Jurusan Siswa</label>
                    <div class="col-sm-10">
                        <select name="optionJurusan" id="jurusan" class="form-control">
                            <option value="">-Pilih Jurusan-</option>
                            <option value="akuntasi">Akuntansi</option>
                            <option value="keperawatan">Keperawatan</option>
                            <option value="bisnis dan pemasaran">Bisnis Dan Pemasaran</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Tahun Masuk</label>
                    <div class="col-sm-10">
                        <input type="date" name="tahun masuk" class="form-control" value="{{ $siswas->tahun_masuk ? \Carbon\Carbon::parse($siswas->tahun_masuk)->format('Y-m-d') : '' }}">
                    </div>
                </div>
                <div class="form-group row" name="gender">
                    <label class="col-sm-2 col-form-label font-weight-normal">Alamat Siswa</label>
                    <div class="col-sm-10">
                        <input type="text" name="alamat_siswa" class="form-control" value="{{ $siswas->alamat_siswa }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Email Siswa</label>
                    <div class="col-sm-10">
                        <input type="email" name="email_siswa" class="form-control" id="email_siswa" value="{{ $siswas->user->email }}">
                        <span id="email_feedback" style="color: red; display: none;">Format email tidak valid</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Password</label>
                    <div class="col-sm-10">
                        <input type="text" name="password" class="form-control" required>
                    </div>
                </div>

                <input type="hidden" name="user_id" value="{{ $siswas->user_id }}">
                <input type="hidden" name="siswa_id" value="{{ $siswas->id }}">

                <button type="submit" form="ubahanggotaform" value="Submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('nama_siswa').addEventListener('input', function (e) {
            var input = e.target.value;
            e.target.value = input.replace(/[^A-Za-z\s]/g, '');
        });

        document.getElementById('nisn').addEventListener('input', function (e) {
            var input = e.target.value;

            // Remove non-digit characters and limit to 4 digits
            if (input.length > 4) {
                input = input.slice(0, 4);
            }

            // Update the input value
            e.target.value = input;
        });

        document.getElementById('email_siswa').addEventListener('input', function (e) {
            var input = e.target.value;
            var feedback = document.getElementById('email_feedback');
            
            // Simple email regex pattern
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            if (emailPattern.test(input)) {
                feedback.style.display = 'none';
            } else {
                feedback.style.display = 'inline';
            }
        });
    </script>
@endsection