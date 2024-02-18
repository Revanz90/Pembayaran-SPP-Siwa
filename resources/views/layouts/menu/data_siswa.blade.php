@extends('main')

@section('title', 'Data Siswa')
@section('title2', 'Data Siswa')
@section('judul', 'Data Siswa')

@section('page-js-files')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@stop

@section('content')
    <section class="content">
        <div id="xtest" style="font-size: 14px"></div>

        <div class="callout callout-warning">
            <i class="fas fa-info-circle"></i>
            Halaman untuk melihat dan menambah data siswa
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
            <!-- Navbar Content -->
            <div class="card-header">
                <h4 class="card-title font-weight-bold">Data Siswa</h4>
                <div class="card-tools">
                    <input type="hidden" name="xnull" id="statusxid[2]" value="2">
                    <div class="project-actions text-center">
                        <!-- <a href="" class="btn btn-warning" role="button"
                            data-bs-toggle="button">
                            <i class="fas fa-print"></i>
                            CETAK</a> -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-plus"></i>
                            TAMBAH
                        </button>
                    </div>
                </div>
            </div>
            <!-- /Navbar Content -->

            <!-- Page Content -->
            <div class="card-body">
                <table id="examplePolos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Alamat</th>
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswas as $siswa)
                            <tr>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama_lengkap }}</td>
                                <td>{{ $siswa->kelas }}</td>
                                <td>{{ $siswa->jurusan }}</td>
                                <td>{{ $siswa->alamat_siswa }}</td>
                                <!-- <td>
                                    <a class="btn btn-info btn-xs text-center d-flex flex-column align-items-stretch"
                                        href="">
                                        <i class="fas fa-folder">
                                        </i>
                                        Lihat
                                    </a>
                                </td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal pinjaman -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog" style="max-width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">Data Siswa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section class="content">
                        <div class="card">
                            <!-- Navbar Content -->
                            <div class="card-header ">
                                <h4 class="card-title font-weight-bold">TAMBAH SISWA</h4>
                                <div class="card-tools"></div>
                            </div>
                            <!-- /Navbar Content -->
                            <!-- Page Content -->
                            <form action="" enctype="multipart/form-data" method="POST" class="form-horizontal"
                                id="datasiswaform">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="form-group row">
                                                    <label for=""
                                                        class="col-sm-2 col-form-label font-weight-bold">NISN</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" name="nisn" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for=""
                                                        class="col-sm-2 col-form-label font-weight-bold">Nama Lengkap</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nama_siswa" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for=""
                                                        class="col-sm-2 col-form-label font-weight-bold">Kelas Siswa
                                                    </label>
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
                                                    <label for=""
                                                        class="col-sm-2 col-form-label font-weight-bold">Jurusan Siswa
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="jurusan" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="proposal_ProposalTA"
                                                        class="col-sm-2 col-form-label font-weight-bold">Alamat Siswa</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="alamat_siswa" class="form-control"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="proposal_ProposalTA"
                                                        class="col-sm-2 col-form-label font-weight-bold">Email Siswa</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="email_siswa" class="form-control"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="proposal_ProposalTA"
                                                        class="col-sm-2 col-form-label font-weight-bold">Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="password" class="form-control"
                                                            required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- /Page Content -->
                        </div>
                    </section>
                </div>
                <!-- /Main Content -->

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <div class="btn-savechange-reset">
                        <!-- <button type="reset" class="btn btn-sm btn-warning" style="margin-right: 5px">Reset</button> -->
                        <button type="submit" form="datasiswaform" value="Submit"
                            class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>

@endsection