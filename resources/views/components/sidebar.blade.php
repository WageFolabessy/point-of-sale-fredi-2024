<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('assets/plugins/adminlte/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">Henx's</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/' . Auth::user()->foto_profil) }}" class="img-circle elevation-2"
                    alt="User Image" />
            </div>
            <div class="info">
                <a href="{{ route('kelola_akun') }}" class="d-block">{{ Auth::user()->nama }}</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon ion ion-grid"></i>
                        <p>
                            MENU
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-cash-register nav-icon"></i>
                                <p>
                                    Kasir
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('kasir_servis') }}"
                                        class="nav-link {{ request()->is('kasir_servis') ? 'active' : '' }}">
                                        <i
                                            class="far fa-{{ request()->is('kasir_servis') ? 'dot-' : '' }}circle nav-icon"></i>
                                        <p>Servis</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('kasir_aksesoris') }}"
                                        class="nav-link {{ request()->is('kasir_aksesoris') ? 'active' : '' }}">
                                        <i
                                            class="far fa-{{ request()->is('kasir_aksesoris') ? 'dot-' : '' }}circle nav-icon"></i>
                                        <p>Aksesoris</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('kasir_pulsa_paket') }}"
                                        class="nav-link {{ request()->is('kasir_pulsa_paket') ? 'active' : '' }}">
                                        <i
                                            class="far fa-{{ request()->is('kasir_pulsa_paket') ? 'dot-' : '' }}circle nav-icon"></i>
                                        <p>Pulsa / Paket Data</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @can('admin')
                            <li class="nav-item">
                                <a href="{{ route('kategori') }}"
                                    class="nav-link {{ request()->is('kategori') ? 'active' : '' }}">
                                    <i class="fas fa-cube nav-icon"></i>
                                    <p>Kategori</p>
                                </a>
                            </li>
                        @endcan
                        @can('admin')
                            <li class="nav-item">
                                <a href="{{ route('produk') }}"
                                    class="nav-link {{ request()->is('produk') ? 'active' : '' }}">
                                    <i class="fas fa-cubes nav-icon"></i>
                                    <p>Produk</p>
                                </a>
                            </li>
                        @endcan
                        @can('admin')
                            <li class="nav-item">
                                <a href="{{ route('pengeluaran') }}"
                                    class="nav-link {{ request()->is('pengeluaran') ? 'active' : '' }}">
                                    <i class="fas fa-dollar-sign nav-icon"></i>
                                    <p>Pengularan</p>
                                </a>
                            </li>
                        @endcan
                        {{-- <li class="nav-item">
                            <a href="{{ route('pembelian') }}" class="nav-link {{ request()->is('pembelian') ? 'active' : '' }}">
                                <i class="fas fa-upload nav-icon"></i>
                                <p>Pembelian</p>
                            </a>
                        </li> --}}
                        @can('admin')
                            <li class="nav-item">
                                <a href="{{ route('penjualan') }}"
                                    class="nav-link {{ request()->is('penjualan') ? 'active' : '' }}">
                                    <i class="fas fa-download nav-icon"></i>
                                    <p>Detail Penjualan</p>
                                </a>
                            </li>
                        @endcan
                        @can('admin')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="ion ion-stats-bars nav-icon"></i>
                                    <p>
                                        Laporan
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('laporan_servis') }}"
                                            class="nav-link {{ request()->is('laporan_servis') ? 'active' : '' }}">
                                            <i
                                                class="far fa-{{ request()->is('laporan_servis') ? 'dot-' : '' }}circle nav-icon"></i>
                                            <p>Servis</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('laporan_aksesoris') }}"
                                            class="nav-link {{ request()->is('laporan_aksesoris') ? 'active' : '' }}">
                                            <i
                                                class="far fa-{{ request()->is('laporan_aksesoris') ? 'dot-' : '' }}circle nav-icon"></i>
                                            <p>Aksesoris</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('laporan_pulsa_paket') }}"
                                            class="nav-link {{ request()->is('laporan_pulsa_paket') ? 'active' : '' }}">
                                            <i
                                                class="far fa-{{ request()->is('laporan_pulsa_paket') ? 'dot-' : '' }}circle nav-icon"></i>
                                            <p>Pulsa / Paket Data</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('kalender') }}"
                                class="nav-link {{ request()->is('kalender') ? 'active' : '' }}">
                                <i class="ion ion-calendar nav-icon"></i>
                                <p>Kalender</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kalkulator') }}"
                                class="nav-link {{ request()->is('kalkulator') ? 'active' : '' }}">
                                <i class="ion ion-calculator nav-icon"></i>
                                <p>Kalkulator</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon ion ion-person"></i>
                        <p>
                            Akun
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('kelola_akun') }}"
                                class="nav-link {{ request()->is('kelola_akun') ? 'active' : '' }}">
                                <i class="ion ion-settings nav-icon"></i>
                                <p>Kelola Akun</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link" id="tombol-keluar">
                                <i class="ion ion-log-out nav-icon"></i>
                                <p>keluar</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
