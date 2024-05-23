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
                    <div class="d-flex justify-content-between">
                        <div class="input-group w-50">
                            <input type="text" class="form-control" id="date-range" placeholder="Select Date Range">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                        </div>
                        <div>
                            <!-- Add a link to generate and download the PDF report -->
                            <!-- <a href="{{ route('cetak.laporan.spp.pdf') }}" class="btn btn-warning" role="button">
                                <i class="fas fa-print"></i>
                                CETAK KARTU SPP
                            </a> -->
                            <button id="download-laporan-pdf" class="btn btn-warning" role="button">
                                <i class="fas fa-print"></i>
                                CETAK LAPORAN
                            </button>
                        </div>                     
                    </div>
                </div>
            </div>
            <!-- /Navbar Content -->

            <!-- Page Content -->
            <div class="card-body">
                <table id="kartu-spp-table" class="table table-bordered table-striped">
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
                                <td>{{ strtoupper($kartu->siswa->jurusan) }}</td>
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
        var date = null;
        $(document).ready(function() {
            // Initialize the date range picker
            $('#date-range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            // Check if there are URL parameters for start_date and end_date
            const urlParams = new URLSearchParams(window.location.search);
            const startDateParam = urlParams.get('start_date');
            const endDateParam = urlParams.get('end_date');

            // If start_date and end_date parameters exist, set the date range picker
            if (startDateParam && endDateParam) {
                $('#date-range').on('apply.daterangepicker', function(ev, picker) {
                    const startDate = moment(startDateParam, 'DD-MM-YYYY');
                    const endDate = moment(endDateParam, 'DD-MM-YYYY');

                    // Update the input field value with the selected date range
                    $(this).val(startDate + ' - ' + endDate);
                });
            }

            // Event handler for when the date range is applied
            $('#date-range').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('DD-MM-YYYY');
                var endDate = picker.endDate.format('DD-MM-YYYY');

                // Update the input field value with the selected date range
                $(this).val(startDate + ' - ' + endDate);
            
                // Send startDate and endDate to the controller via AJAX
                $.ajax({
                    url: '/laporan-spp',
                    method: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        // Handle the response here, such as updating the page with the new data
                        console.log(response);

                        // Clear existing content
                        $('#kartu-spp-table tbody').empty();

                        // Iterate over each object in the response array
                        response.forEach(function(kartuSpp) {
                            // Extract relevant data from the object
                            var namaSiswa = kartuSpp.siswa.nama_lengkap;
                            var kelasSiswa = kartuSpp.siswa.kelas;
                            var jurusanSiswa = kartuSpp.siswa.jurusan;
                            var setoranBulan = moment(kartuSpp.setoran_untuk_bulan).format('MMMM YYYY');
                            var nilaiSetoran = kartuSpp.nilai_setoran;
                            var statusSetoran = kartuSpp.status_setoran.toUpperCase();
                            var diterimaOleh = kartuSpp.penerimapembayaranspp.name.toUpperCase();

                            // Create a new table row with the extracted data
                            var row = '<tr>' +
                                        '<td>' + namaSiswa + '</td>' +
                                        '<td>' + kelasSiswa + '</td>' +
                                        '<td>' + jurusanSiswa + '</td>' +
                                        '<td>' + setoranBulan + '</td>' +
                                        '<td>' + nilaiSetoran + '</td>' +
                                        '<td>' + statusSetoran + '</td>' +
                                        '<td>' + diterimaOleh + '</td>' +
                                    '</tr>';

                            // Append the new row to the table body
                            $('#kartu-spp-table tbody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors here
                        console.error(xhr.responseText);
                    }
                });
            });

            // Event handler for when the date range is cleared
            $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
                // Clear the input field
                $(this).val('');
            });

            // Event handler for when the "CETAK KARTU SPP" button is clicked
            $('#download-laporan-pdf').click(function(e) {
                e.preventDefault(); // Prevent the default action of the link
                
                // Get the start and end dates from the date range picker
                var startDate = $('#date-range').data('daterangepicker').startDate.format('DD-MM-YYYY');
                var endDate = $('#date-range').data('daterangepicker').endDate.format('DD-MM-YYYY');

                // Generate the URL with the start and end dates
                var url = "{{ route('cetak.laporan.spp.pdf') }}?start_date=" + startDate + "&end_date=" + endDate;

                // Redirect the user to the generated URL
                window.location.href = url;
            });
        });
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
