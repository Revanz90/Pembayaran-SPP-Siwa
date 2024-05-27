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
                    <h2 class="card-title font-weight-bold">Filter Laporan</h2>
                    <div class="d-flex justify-content-end">
                        <div class="w-50 mr-1">
                            <select name="optionJurusan" id="jurusan" class="form-control">
                                <option value="">-Jurusan-</option>
                                <option value="akuntasi">Akuntansi</option>
                                <option value="keperawatan">Keperawatan</option>
                                <option value="bisnis dan pemasaran">Bisnis Dan Pemasaran</option>
                            </select>
                        </div>

                        <div class="w-50 mr-1">
                            <select name="optionKelasSiswa" id="kelasSiswa" class="form-control">
                                <option value=""> -Kelas- </option>
                                <option value="x">Kelas X</option>
                                <option value="xi">Kelas XI</option>
                                <option value="xii">Kelas XII</option>
                            </select>
                        </div>

                        <div class="w-50 mr-1">
                            <select name="statusPembayaran" id="statusPembayaran" class="form-control">
                                <option value=""> -Status- </option>
                                <option value="belum dibayar">Belum Dibayar</option>
                                <option value="sudah ditransfer">Sudah Transfer</option>
                                <option value="diterima bendahara">Diterima bendahara</option>
                            </select>
                        </div>

                        <div class="input-group mr-1">
                            <input type="text" class="form-control" id="date-range" placeholder="Pilih Rentang Tanggal">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                        </div>

                        <div class="input-group d-flex justify-content-end">
                            <button id="download-laporan-pdf" class="btn btn-warning" role="button">
                                CETAK LAPORAN
                            </button>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-print"></i></span>
                            </div>
                        </div>                   
                    </div>
                </div>
            </div>
            <!-- /Navbar Content -->

            <!-- Page Content -->
            <div class="card-body">
                <table id="pendapatan-table" class="table table-bordered table-striped mb-4">
                    <thead>
                        <tr>
                            <th>Pemasukan</th>
                            <th>Belum Dibayar</th>
                            <th>Sudah Dibayar</th>
                            <th>Diterima Bendahara</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $totalNilaiSetoran }}</td>
                            <td>{{ $countBelumBayar }}</td>
                            <td>{{ $countSudahTransfer }}</td>
                            <td>{{ $countDiterimaBendahara }}</td>
                        </tr>
                    </tbody>
                </table>

                <table id="kartu-spp-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Setoran Untuk Bulan</th>
                            <th>Nominal</th>
                            <!-- <th>Status</th> -->
                            <th>Diterima Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $no = 1; @endphp
                        @foreach($kartuSpps as $kartu)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $kartu->siswa->nama_lengkap }}</td>
                                <td>{{ $kartu->siswa->kelas }}</td>
                                <td>{{ strtoupper($kartu->siswa->jurusan) }}</td>
                                <td>{{ \Carbon\Carbon::parse($kartu->setoran_untuk_bulan)->formatLocalized('%B %Y') ?? '' }}</td>
                                <td>{{ $kartu->nilai_setoran ?? '' }}</td>
                                <!-- <td>{{ strtoupper($kartu->status_setoran ?? '') }}</td> -->
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

            // Event handler for when the date range is applied
            $('#date-range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                fetchFilteredData();
            });

            // Event handler for when the date range is cleared
            $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                fetchFilteredData();
            });

            // Event handlers for the select dropdowns
            $('#jurusan, #kelasSiswa, #statusPembayaran').change(function() {
                fetchFilteredData();
            });

            function fetchFilteredData(){
                var dateRange = $('#date-range').val().split(' - ');
                var startDate = dateRange[0] ? moment(dateRange[0], 'DD-MM-YYYY').format('YYYY-MM-DD') : null;
                var endDate = dateRange[1] ? moment(dateRange[1], 'DD-MM-YYYY').format('YYYY-MM-DD') : null;
                var jurusan = $('#jurusan').val();
                var kelasSiswa = $('#kelasSiswa').val();
                var statusPembayaran = $('#statusPembayaran').val();

                // Prepare data object
                var data = {};

                if (startDate) data.start_date = startDate;
                if (endDate) data.end_date = endDate;
                if (jurusan) data.jurusan = jurusan;
                if (kelasSiswa) data.kelas = kelasSiswa;
                if (statusPembayaran) data.status = statusPembayaran;

                // Send the data to the controller via AJAX
                $.ajax({
                    url: '/laporan-spp',
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        // Handle the response here, such as updating the page with the new data
                        console.log(response);

                        // Clear existing content
                        $('#kartu-spp-table tbody').empty();

                        // Initialize a counter for row numbers
                        var counter = 1;

                        // Iterate over each object in the response array
                        response.kartuSpps.forEach(function(kartuSpp) {
                            // Extract relevant data from the object
                            var namaSiswa = kartuSpp.siswa ? kartuSpp.siswa.nama_lengkap || '' : '';
                            var kelasSiswa = kartuSpp.siswa ? kartuSpp.siswa.kelas || '' : '';
                            var jurusanSiswa = kartuSpp.siswa ? kartuSpp.siswa.jurusan || '' : '';
                            var setoranBulan = kartuSpp.setoran_untuk_bulan ? moment(kartuSpp.setoran_untuk_bulan).format('MMMM YYYY') : '';
                            var nilaiSetoran = kartuSpp.nilai_setoran || '';
                            // var statusSetoran = kartuSpp.status_setoran.toUpperCase();
                            var diterimaOleh = kartuSpp.penerimapembayaranspp ? kartuSpp.penerimapembayaranspp.name.toUpperCase() || '' : '';

                            // Create a new table row with the extracted data
                            var row = '<tr>' +
                                    '<td>' + (counter || '') + '</td>' +
                                    '<td>' + (namaSiswa || '') + '</td>' +
                                    '<td>' + (kelasSiswa || '') + '</td>' +
                                    '<td>' + (jurusanSiswa || '') + '</td>' +
                                    '<td>' + (setoranBulan || '') + '</td>' +
                                    '<td>' + (nilaiSetoran || '') + '</td>' +
                                    // '<td>' + (statusSetoran || '') + '</td>' +
                                    '<td>' + (diterimaOleh || '') + '</td>' +
                                '</tr>';

                            // Append the new row to the table body
                            $('#kartu-spp-table tbody').append(row);

                            // Increment the counter
                            counter++;

                            // Update the summary table
                            $('#pendapatan-table tbody tr').html(
                                '<td>' + (response.totalNilaiSetoran || 0) + '</td>' +
                                '<td>' + (response.countBelumBayar || 0) + '</td>' +
                                '<td>' + ((response.countSudahTransfer || 0)) + '</td>' +
                                '<td>' + ((response.countDiterimaBendahara || 0)) + '</td>'
                            );
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors here
                        console.error(xhr.responseText);
                    }
                });
            }

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
