@extends('main')

@section('title', 'Terima Pembayaran SPP')
@section('title2', 'Terima Pembayaran SPP')
@section('judul', 'Terima Pembayaran SPP')

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
                            <th>Jatuh Tempo</th>
                            <th>Keterlambatan SPP</th>
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
                                    <td>{{ \Carbon\Carbon::parse($kartu->tanggal_jatuh_tempo)->formatLocalized('%d %B') ?? '' }}</td>
                                    <td>
                                        @if(isset($kartu->jumlah_hari_terlambat) && $kartu->jumlah_hari_terlambat >= 0)
                                            {{ $kartu->jumlah_hari_terlambat }} Hari
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $kartu->nilai_setoran ?? '' }}</td>
                                    <td>{{ strtoupper($kartu->status_setoran ?? '') }}</td>
                                    <td>{{ strtoupper($kartu->penerimapembayaranspp ? $kartu->penerimapembayaranspp->name : '') }}</td>
                                    <td>
                                    @if($kartu->status_setoran === 'sudah ditransfer')
                                        @hasrole('admin|bendahara1')
                                            <button type="button" class="btn btn-primary btnTerimaSPP" data-id="{{ $kartu->id }}" data-toggle="modal" data-target="#modal-default">
                                                <i class="fas fa-donate"></i>
                                                Verifikasi Pembayaran SPP
                                            </button>
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

    <!-- Modal Terima SPP -->
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
                            <div class="card-header">
                                <h4 class="card-title font-weight-bold">TERIMA BUKTI TRANSFER TAGIHAN</h4>
                                <div class="card-tools">
                                    @hasrole('admin|bendahara1')
                                        <form method="POST" action="{{ route('terima.spp', ['id' => $kartu->id]) }}">
                                            @csrf
                                                <button class="btn btn-info btn-md border border-secondary" >
                                                    <i class="fas fa-donate"></i>
                                                    Terima SPP
                                                </button>
                                        </form>
                                    <!-- <form id="terima-spp-form" action="{{ route('terima.spp', ['id' => '__id__']) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" id="form-id">
                                        <button type="button" class="btn btn-info btn-md btnTerimaSPP" data-target="#modal-default">
                                            <i class="fas fa-donate"></i>
                                            Terima SPP
                                        </button>
                                    </form> -->
                                    @endhasrole
                                </div>
                            </div>
                            <!-- /Navbar Content -->

                            <!-- Page Content -->
                            <div class="card-body">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label font-weight-normal">Tanggal Transfer</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="tanggal_transfer" id="tanggal_transfer" class="form-control" value="" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label font-weight-normal">Setoran untuk Bulan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="setoran_untuk_bulan" id="setoran_untuk_bulan" class="form-control" value="" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label font-weight-normal">Nominal Transfer</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="nominal_transfer" id="nominal_transfer" class="form-control" value="" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label font-weight-normal">Bukti Transfer</label>
                                                <div class="card-footer bg-white col-sm-10">
                                                    <embed type="application/pdf" id="bukti_transfer" frameborder="0" width="100%" height="780">
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Page Content -->
                        </div>
                    </section>
                </div>
                <!-- /Main Content -->

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <div class="btn-savechange-reset">
                        <!-- <button type="reset" class="btn btn-sm btn-warning" style="margin-right: 5px">Reset</button> -->
                        <!-- <button type="submit" form="dataTransferTagihan" value="Submit"
                            class="btn btn-primary">Upload</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Use event delegation to handle click events on dynamically generated buttons
            $(document).on('click', '.btnTerimaSPP', function () {
                var id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: '/terima-tagihan-spp/details/' + id,
                    success: function (response) {
                        // Handle SPP payment details
                        var tanggalTransfer = new Date(response.spp_payment.tanggal_transfer);
                        var formattedTanggalTransfer = tanggalTransfer.getDate() + ' ' + getMonthName(tanggalTransfer.getMonth()) + ' ' + tanggalTransfer.getFullYear();
                        $('#tanggal_transfer').val(formattedTanggalTransfer);

                        var setoran_bulan = new Date(response.spp_payment.setoran_untuk_bulan);
                        var formattedPeriodPayment = getMonthName(tanggalTransfer.getMonth());
                        $('#setoran_untuk_bulan').val(formattedPeriodPayment);

                        // Other code remains unchanged
                        $('#nominal_transfer').val(response.spp_payment.nilai_setoran);

                        // Handle associated files
                        var filesHtml = '';
                        if (response.payment_files.length > 0) {
                            response.payment_files.forEach(function(file) {
                                // Assuming response contains the file path
                                var filePath = file.bukti_transfer;

                                // Construct the URL for accessing the file
                                var fileUrl = "{{ url('storage/') }}/" + filePath;

                                // Set the src attribute of the embed tag
                                $('#bukti_transfer').attr('src', fileUrl);
                            });
                        } else {
                            filesHtml = '<p>No files uploaded</p>';
                        }

                        // Set the HTML content of the bukti_transfer element
                        $('#bukti_transfer').html(filesHtml);


                        // Show the modal
                        $('#modal-default').modal('show');
                        console.log(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Function to get month name from month number
            function getMonthName(monthNumber) {
                var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                return months[monthNumber];
            }
        });
    </script>

@endsection
