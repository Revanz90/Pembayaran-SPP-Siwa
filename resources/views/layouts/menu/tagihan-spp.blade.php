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
            <div class="card-header">
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
                    @if($siswa)
                    <div style="display: grid; grid-template-columns: 1fr 20px 10fr; gap: 10px;">
                        <div>
                            <p><strong>Nama Siswa</strong></p>
                            <p><strong>Kelas</strong></p>
                            <p><strong>Jurusan</strong></p>
                            <p><strong>Alamat</strong></p>
                            <p><strong>Besarnya SPP</strong></p>
                        </div>
                        <div>
                            <p><strong>:</strong></p>
                            <p><strong>:</strong></p>
                            <p><strong>:</strong></p>
                            <p><strong>:</strong></p>
                            <p><strong>:</strong></p>
                        </div>
                        <div>
                            <p>{{ $siswa->nama_lengkap }}</p>
                            <p>{{ $siswa->kelas }}</p>
                            <p>{{ $siswa->jurusan }}</p>
                            <p>{{ $siswa->alamat_siswa }}</p>
                            <p>Rp. 110.000</p>
                        </div>
                    </div>
                    @endif
                </div>

                <table id="examplePolos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Setoran Untuk Bulan</th>
                            <th>Besarnya Rp.</th>
                            <th>Tanda Tangan Penerima</th>
                            <!-- <th>Alamat</th> -->
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>22 Juli 2023</td>
                                <td>Juli</td>
                                <td>110.000</td>
                                <td>Diterima Bendahara 2</td>
                                <!-- <td>Jalan Kledokan</td> -->
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