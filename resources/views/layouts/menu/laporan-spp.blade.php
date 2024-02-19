@extends('main')

@section('title', 'Laporan SPP')
@section('title2', 'Laporan SPP')
@section('judul', 'Laporan SPP')

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
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title font-weight-bold">Laporan SPP</h2>
                    <div class="input-group w-50">
                        <input type="text" class="form-control" id="date-range" placeholder="Select Date Range">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Navbar Content -->

            <!-- Page Content -->
            <div class="card-body">
                <table id="examplePolos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Setoran Untuk Bulan</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Diterima Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kartuSpps as $kartu)
                            <tr>
                                <td>{{ $kartu->siswa->nama_lengkap }}</td>
                                <td>{{ $kartu->siswa->kelas }}</td>
                                <td>{{ $kartu->siswa->jurusan }}</td>
                                <td>{{ \Carbon\Carbon::parse($kartu->setoran_untuk_bulan)->formatLocalized('%B') ?? '' }}</td>
                                <td>{{ $kartu->nilai_setoran ?? '' }}</td>
                                <td>{{ strtoupper($kartu->status_setoran ?? '') }}</td>
                                <td>{{ strtoupper($kartu->penerimapembayaranspp ? $kartu->penerimapembayaranspp->name : '') }}</td>
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
                    <!-- Main Content -->
                    <section class="content">
                        <div class="card">
                            <!-- Navbar Content -->
                            <div class="card-header">
                                <h4 class="card-title font-weight-bold">TERIMA BUKTI TRANSFER TAGIHAN</h4>
                                <div class="card-tools">
                                    @hasrole('admin|bendahara1')
                                    <form id="terima-spp-form" method="POST" action="{{ route('terima.spp', ['id' => '__id__']) }}">
                                        @csrf
                                        <input type="hidden" name="id" id="form-id">
                                        <button class="btn btn-info btn-md border border-secondary btnTerimaSPP" data-target="#modal-default">
                                            <i class="fas fa-donate"></i>
                                            Terima SPP
                                        </button>
                                    </form>
                                    @endhasrole
                                </div>
                            </div>
                            <!-- /Navbar Content -->

                            <!-- Page Content -->
                            <div class="card-body">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Your form content here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Page Content -->
                        </div>
                    </section>
                    <!-- /Main Content -->
                </div>

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
        $(document).ready(function() {
            // Initialize the date range picker
            $('#date-range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            // Event handler for when the date range is applied
            $('#date-range').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('DD-MM-YYYY');
                var endDate = picker.endDate.format('DD-MM-YYYY');
                // Send startDate and endDate to the controller
                window.location.href = '/laporan-spp?start_date=' + startDate + '&end_date=' + endDate;
            });

            // Event handler for when the date range is cleared
            $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
                // Clear the input field
                $(this).val('');
            });
        });

        // var date = null;
        // jQuery(document).ready(function($) {
        //     $(document).ready(function() {
        //         $('#date-range').datepicker({
        //             format: 'dd-mm-yyyy',
        //             autoclose: true,
        //             todayHighlight: true
        //         }).on('changeDate', function(e) {
        //             var selectedDate = e.format('dd-mm-yyyy');
        //             console.log(selectedDate); // This will log the selected date in the console
        //             date = selectedDate;
        //             // You can do further processing with the selected date here
        //         });
        //     });
        // });

        // $(document).ready(function() {
        //     $('#date-range').daterangepicker({
        //         autoUpdateInput: false,
        //         locale: {
        //             cancelLabel: 'Clear'
        //         }
        //     });

        //     $('#date-range').on('apply.daterangepicker', function(ev, picker) {
        //         // $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        //         var startDate = picker.startDate.format('YYYY-MM-DD');
        //         var endDate = picker.endDate.format('YYYY-MM-DD');
        //         date = { start: startDate, end: endDate }; // Store start and end dates in date variable
        //         $(this).val(startDate + ' - ' + endDate); // Update input field with selected range
        //         // Perform further processing with the selected date range here
        //         console.log(date);
        //     });

        //     $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
        //         $(this).val('');
        //         date = null;
        //     });
        // });
    </script>

    
    <style>
        /* Override default styles for Bootstrap Datepicker */
        .datepicker-dropdown.show {
            background-color: #fff !important; /* Set background color to white */
            border: 1px solid #ced4da !important; /* Add border */
            color: #000 !important; /* Set text color to black */
        }

        /* Override text color for Bootstrap Datepicker input */
        .datepicker-dropdown.show .datepicker-days .datepicker-switch,
        .datepicker-dropdown.show .datepicker-days .table-condensed>thead>tr>th,
        .datepicker-dropdown.show .datepicker-days .table-condensed>tbody>tr>td,
        .datepicker-dropdown.show .datepicker-days .table-condensed>tbody>tr>th,
        .datepicker-dropdown.show .datepicker-months .datepicker-switch,
        .datepicker-dropdown.show .datepicker-months .table-condensed>thead>tr>th,
        .datepicker-dropdown.show .datepicker-months .table-condensed>tbody>tr>td,
        .datepicker-dropdown.show .datepicker-months .table-condensed>tbody>tr>th,
        .datepicker-dropdown.show .datepicker-years .datepicker-switch,
        .datepicker-dropdown.show .datepicker-years .table-condensed>thead>tr>th,
        .datepicker-dropdown.show .datepicker-years .table-condensed>tbody>tr>td,
        .datepicker-dropdown.show .datepicker-years .table-condensed>tbody>tr>th {
            color: #000 !important; /* Set text color to black */
        }
    </style>

@endsection
