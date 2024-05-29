<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Kartu SPP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            position: relative; /* Set header to relative positioning */
            /* padding-top: 3rem; */
        }

        .header-content {
            display: flex;
            flex-direction: column;
            gap: 0.5rem; /* Add space between image and text */
        }

        .header img {
            position: absolute; /* Set image to absolute positioning */
            top: 0;
            left: 0;
            opacity: 0.8;
            z-index: -1; /* Move the image behind the content */
        }

        .header-text p {
            text-align: center;
            margin-top: 0.4rem; /* Remove default top margin */
            margin-bottom: 0.4rem; /* Remove default bottom margin */  
        }

        .title {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 2rem;
        }

        .title-container {
            text-align: center; /* Center the text inside the container */
        }

        .content {
            display: flex;
            justify-content: left;
        }

        .student-info {
            margin-right: 1rem;
        }

        .student-info p {
            margin: 0;
            line-height: 1.5;
        }

        .table-container {
            padding-top: 2rem;
            /* padding-left: 3rem;
            padding-right: 3rem; */
        }

        /* Add borders to table and center text in th */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 8px; /* Adjust padding as needed */
            vertical-align: middle;
        }

        .signature {
            display: flex;
            justify-content: flex-end;
            padding-top: 1.5rem;
        }

        .signature-content {
            text-align: center; /* Align the text to the right */
        }

        .signature p {
            margin: 0;
        }

        hr {
            border: none; /* Remove default border */
            border-top: 2px solid black; /* Set the top border to create a bold effect */
        }
    </style>
</head>

<body>
    <!-- Header Content -->
    <header class="header">
        <div class="header-content">
            <div class="header-text">
                <p><strong>SMK YAPEMDA 1 SLEMAN</strong></p>
                <p><strong>TERAKREDITASI "A"</strong></p>
                <p><strong>Tanjungtirto, Kalitirto, Berbah, Sleman, Yogyakarta</strong></p>
                <p><strong>Telp/Fax (0274) 495430</strong></p>
            </div>
        </div>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/yapemda1sleman.png'))) }}" 
                alt="Logo SMK" name="logo-smk-yapemda" class="brand-image img-circle elevation-3">
        <hr>
    </header>


    <!-- Title -->
    <div class="title">
        <div class="title-container">
            <p><strong>KARTU PEMBAYARAN SPP</strong></p>
        </div>
    </div>


    <!-- Page Content -->
    <div class="content">
        @if($siswa)
            <div class="student-info">
                <p><strong>Nama Siswa :</strong> {{ $siswa->nama_lengkap }}</p>
                <p><strong>Kelas :</strong> {{ $siswa->kelas }}</p>
                <p><strong>Jurusan :</strong> {{ $siswa->jurusan }}</p>
                <p><strong>Alamat :</strong> {{ $siswa->alamat_siswa }}</p>
                <p><strong>Besarnya SPP :</strong> Rp. 110.000</p>
            </div>
        @endif
    </div>
    
    <!-- Table Content -->
    <div class="table-container">
        <table id="examplePolos" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal Transfer</th>
                    <th>Setoran Untuk Bulan</th>
                    <!-- <th>Jatuh Tempo</th> -->
                    <!-- <th>Keterlambatan SPP</th> -->
                    <th>Besarnya Rp.</th>
                    <th>Status</th>
                    <th>Diterima Oleh</th>
                </tr>
            </thead>
            <tbody>
                @if($existingKartuSPP)
                    @foreach ($kartuspp as $kartuspp)
                        <tr>
                            <td>{{ isset($kartuspp->tanggal_transfer) ? \Carbon\Carbon::parse($kartuspp->tanggal_transfer)->translatedFormat('d F Y') : '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($kartuspp->setoran_untuk_bulan)->formatLocalized('%B') ?? '' }}</td>
                            <!-- <td>{{ \Carbon\Carbon::parse($kartuspp->tanggal_jatuh_tempo)->formatLocalized('%d %B') ?? '' }}</td> -->
                            <!-- <td>
                                @if(isset($kartuspp->jumlah_hari_terlambat) && $kartuspp->jumlah_hari_terlambat >= 0)
                                    {{ $kartuspp->jumlah_hari_terlambat }} Hari
                                @else
                                    -
                                @endif
                            </td> -->
                            <td>{{ $kartuspp->nilai_setoran ?? '' }}</td>
                            <td>{{ strtoupper($kartuspp->status_setoran ?? '') }}</td>
                            <td>{{ strtoupper($kartuspp->penerimapembayaranspp ? $kartuspp->penerimapembayaranspp->name : '') }}</td>
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
        <p><strong>Catatan : Jatuh tempo PEMBAYARAN paling lambat Tanggal 10 tiap bulan</strong></p>
    </div>

    <!-- Signature -->
    <div class="signature">
        <div class="signature-content">
            <p><strong>Berbah, {{ \Carbon\Carbon::parse($dateNow)->translatedFormat('d F Y') }}</strong></p>
            <p><strong>Kepala Sekolah,</strong></p>
            <br><br><br>
            <p><strong>SINGGIH WIRATMA,SH.</strong></p>
            <p><strong>NIP. -</strong></p>
        </div>
    </div>

</body>

</html>
