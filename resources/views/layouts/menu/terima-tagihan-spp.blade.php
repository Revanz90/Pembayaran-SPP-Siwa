@extends('main')

@section('title', 'Terima Pembayaran SPP')
@section('title2', 'Terima Pembayaran SPP')
@section('judul', 'Terima Pembayaran SPP')

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
                <h2 class="card-title font-weight-bold">Terima Pembayaran SPP</h2>
                <div class="card-tools">
                    <div class="project-actions text-center">
                            <a href="" class="btn btn-warning" role="button"
                                data-bs-toggle="button">
                                <i class="fas fa-print"></i>
                                CETAK</a>
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                                <i class="fas fa-donate"></i>
                                Bayar SPP
                            </button> -->
                    </div>
                </div>
            </div>
            <!-- /Navbar Content -->

            <!-- Page Content -->
            <div class="card-body">

                <table id="examplePolos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Transfer</th>
                            <th>Setoran Untuk Bulan</th>
                            <th>Besarnya Rp.</th>
                            <th>Status</th>
                            <th>Diterima Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kartuspp as $kartu)
                                <tr>
                                    <td>{{ isset($kartu->tanggal_transfer) ? \Carbon\Carbon::parse($kartu->tanggal_transfer)->translatedFormat('d F Y') : '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($kartu->setoran_untuk_bulan)->formatLocalized('%B') ?? '' }}</td>
                                    <td>{{ $kartu->nilai_setoran ?? '' }}</td>
                                    <td>{{ strtoupper($kartu->status_setoran ?? '') }}</td>
                                    <td>{{ strtoupper($kartu->penerimapembayaranspp ? $kartu->penerimapembayaranspp->name : '') }}</td>
                                    <td>
                                    @if($kartu->status_setoran === 'sudah ditransfer')
                                        @hasrole('admin|kepalaSekolah|bendahara')
                                            <form method="POST" action="{{ route('terima.spp', ['id' => $kartu->id]) }}">
                                                @csrf
                                                <button class="btn btn-info btn-xs w-100 border border-secondary" >
                                                    <i class="fas fa-donate"></i>
                                                    Terima SPP
                                                </button>
                                            </form>
                                        @endhasrole
                                    @endif
                                    </td>
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
                                                                        <option value="Coba">
                                                                            Coba
                                                                        </option>
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
@endsection