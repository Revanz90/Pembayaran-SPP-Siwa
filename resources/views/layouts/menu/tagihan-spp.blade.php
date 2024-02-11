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
                        @if($existingKartuSPP)
                            <a href="" class="btn btn-warning" role="button"
                                data-bs-toggle="button">
                                <i class="fas fa-print"></i>
                                CETAK</a>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                                <i class="fas fa-donate"></i>
                                Bayar SPP
                            </button>
                        @endif
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
                            <th>Tanggal Transfer</th>
                            <th>Setoran Untuk Bulan</th>
                            <th>Besarnya Rp.</th>
                            <th>Status Penerima</th>
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @if($existingKartuSPP)
                            @foreach ($kartu as $kartuspp)
                                <tr>
                                    <td>{{ isset($kartuspp->tanggal_transfer) ? \Carbon\Carbon::parse($kartuspp->tanggal_transfer)->translatedFormat('d F Y') : '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($kartuspp->setoran_untuk_bulan)->formatLocalized('%B') ?? '' }}</td>
                                    <td>{{ $kartuspp->nilai_setoran ?? '' }}</td>
                                    <td>{{ strtoupper($kartuspp->status_setoran ?? '') }}</td>
                                    <!-- <td> -->
                                        <!-- <button type="button" class="btn btn-info btn-xs text-center d-flex flex-column align-items-stretch" data-toggle="modal" data-target="#modal-default">
                                            <i class="fas fa-donate"></i>
                                            Bayar SPP
                                        </button> -->
                                    <!-- </td> -->
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-danger" colspan="5">
                                    Kartu belum diterbitkan
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal pinjaman -->
    @if($existingKartuSPP)
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog" style="max-width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tagihan SPP Siswa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section class="content">
                            <div class="card">
                                <!-- Navbar Content -->
                                <div class="card-header ">
                                    <h4 class="card-title font-weight-bold">UPLOAD BUKTI TRANSFER TAGIHAN</h4>
                                    <div class="card-tools"></div>
                                </div>
                                <!-- /Navbar Content -->

                                <!-- Page Content -->
                                <form action="" enctype="multipart/form-data" method="POST" class="form-horizontal" id="dataTransferTagihan">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-body">

                                                    <div class="form-group row">
                                                        <label for=""
                                                            class="col-sm-2 col-form-label font-weight-normal">Tanggal Transfer</label>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="tanggal_transfer" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="setoran_untuk_bulan" class="col-sm-2 col-form-label font-weight-normal">Setoran untuk Bulan</label>
                                                        <div class="col-sm-10">
                                                            <select name="setoran_untuk_bulan" class="form-control">
                                                                @foreach($kartu as $item)
                                                                    <option value="{{ $item->setoran_untuk_bulan }}">{{ \Carbon\Carbon::parse($item->setoran_untuk_bulan)->formatLocalized('%B') }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for=""
                                                            class="col-sm-2 col-form-label font-weight-normal">Nominal Transfer</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="nominal" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="proposal_ProposalTA"
                                                            class="col-sm-2 col-form-label font-weight-normal">Bukti Transfer</label>
                                                        <div class="col-sm-10">
                                                            <input type="file" name="bukti_transfer" class="form-control"
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
                            <button type="submit" form="dataTransferTagihan" value="Submit"
                                class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    @endif
@endsection