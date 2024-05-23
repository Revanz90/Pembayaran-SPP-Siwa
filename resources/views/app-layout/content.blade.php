@section('judul', 'Dashboard')

<section class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <br>
                    <h5><strong>Pembayaran SPP</strong></h5>
                    <h6>Sistem Informasi Pembayaran SPP SMK Yapemda 1 Sleman</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row">
    @hasrole('admin|kepalaSekolah|bendahara1')
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-teal">
            <div class="inner">
                <!-- <h3>1</h3> -->
                <p>Data Siswa</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('datasiswa') }}" class="small-box-footer">Lihat Siswa <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>2</h3>
                <p>Kartu SPP</p>
            </div>
            <div class="icon">
                <i class="ion ion-folder"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat Kartu <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div> -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <!-- <h3>3</h3> -->
                <p>Tagihan SPP</p>
            </div>
            <div class="icon">
                <i class="ion ion-card"></i>
            </div>
            <a href="{{ route('kartu.spp') }}" class="small-box-footer">Lihat Tagihan <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- <div class="col-lg-3 col-6"> -->
        <!-- small box -->
        <!-- <div class="small-box bg-success">
            <div class="inner">
                <h3>4</h3>
                <p>Data Angsuran</p>
            </div>
            <div class="icon">
                <i class="ion ion-compose"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat Info <i class="fas fa-arrow-circle-right"></i></a>
        </div> -->
    <!-- </div> -->
    @endhasrole
</div>

<section class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <br>
                    <h5><strong>Selamat datang, {{ auth()->user()->name }}</strong></h5>
                </div>
            </div>
        </div>
    </div>
</section>
