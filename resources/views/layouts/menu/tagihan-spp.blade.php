@extends('main')

@section('title', 'Tagihan SPP')
@section('title2', 'Tagihan SPP')
@section('judul', 'Tagihan SPP')

@section('page-js-files')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@stop

@section('content')
    <section class="content">
        <div id="xtest" style="font-size: 14px"></div>

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
            <div class="card-header items-center">
                <h2 class="card-title font-weight-bold">Kartu Pembayaran SPP</h2>
                <div class="card-tools">
                    <div class="project-actions text-center">
                        <a href="" class="btn btn-warning" role="button"
                            data-bs-toggle="button">
                            <i class="fas fa-print"></i>
                            CETAK</a>
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-plus"></i>
                            TAMBAH
                        </button> -->
                    </div>
                </div>
            </div>
            <!-- /Navbar Content -->

            <!-- Page Content -->
            <div class="card-body">
                <div>
                    <p>Nama Siswa</p>
                    <p>Kelas</p>
                    <p>Alamat</p>
                    <p>Besarnya SPP</p>
                </div>


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
                            <tr>
                                <td>001</td>
                                <td>Jihan</td>
                                <td>X</td>
                                <td>Akuntansi</td>
                                <td>Jalan Kledokan</td>
                                <!-- <td>
                                    <a class="btn btn-info btn-xs text-center d-flex flex-column align-items-stretch"
                                        href="">
                                        <i class="far fa-credit-card">
                                        </i>
                                        Terbitkan SPP
                                    </a>
                                </td> -->
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection