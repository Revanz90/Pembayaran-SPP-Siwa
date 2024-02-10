<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="/img/yapemda1sleman.png" alt="Logo PKK" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Pembayaran SPP Siswa</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('AdminLTE/dist') }}/img/user2-160x160.jpg" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            {{-- @foreach ($useractive as $username) --}}
            <div class="info">
                <a href="" class="d-block">{{ auth()->user()->name }}</a>
            </div>
            {{-- @endforeach --}}
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">MAIN MENU</li>
                    @hasrole('admin|kepalaSekolah|bendahara')
                        <li class="nav-item {{ request()->routeIs('datasiswa') ? 'menu-open' : '' }}">
                            <a href="{{ route('datasiswa') }}" class="nav-link">
                                <i class="nav-icon far fa-user"></i>
                                <p>
                                    Data Siswa
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('kartu.spp') ? 'menu-open' : '' }}">
                            <a href="{{ route('kartu.spp') }}" class="nav-link">
                                <i class="nav-icon far fa-credit-card"></i>
                                <p>
                                    Kartu SPP
                                </p>
                            </a>
                        </li>
                    @endhasrole

                @hasrole('admin|kepalaSekolah|bendahara|siswa')
                    <li class="nav-item {{ request()->routeIs('tagihan.spp') ? 'menu-open' : '' }}">
                        <a href="{{ route('tagihan.spp') }}" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                Tagihan SPP
                            </p>
                        </a>
                    </li>
                @endhasrole
            </ul>
        </nav>
    </div>
</aside>
