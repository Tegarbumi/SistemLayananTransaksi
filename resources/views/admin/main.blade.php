<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Sanss - Sewa Alat Camping Terbaik</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.jpg') }}" />

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="{{ asset('css/adminstyles.css') }}" rel="stylesheet" />

    <!-- FontAwesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    {{-- Optional custom styles --}}
    @stack('styles')
</head>

<body class="sb-nav-fixed">

<!-- ================= NAVBAR ================= -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark shadow-sm">
    <a class="navbar-brand ps-3 fw-bold" href="{{ route('admin.index') }}">
        Admin Area
    </a>

    <button class="btn btn-link btn-sm me-3" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item" href="{{ route('akun.pengaturan') }}">
                        <i class="fas fa-cog me-2"></i>Pengaturan Akun
                    </a>
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<div id="layoutSidenav">

   <!-- ================= SIDEBAR ================= -->
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark">

        <div class="sb-sidenav-menu">
            <div class="nav">

                {{-- ================= ADMIN ONLY ================= --}}
                @if(Auth::user()->role == 2)

                <a class="nav-link {{ Route::is('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <a class="nav-link {{ Route::is('admin.grafik') ? 'active' : '' }}" href="{{ route('admin.grafik') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                    Grafik Pemasukan
                </a>

                @endif


                {{-- ================= RESERVASI (ADMIN + KASIR) ================= --}}
                <div class="sb-sidenav-menu-heading">Manajemen Reservasi</div>

                @if(Auth::user()->role == 2)
                <button type="button" class="btn btn-success nav-link text-start mb-1"
                        data-bs-toggle="modal" data-bs-target="#cetakLaporanModal">
                    <i class="fas fa-print me-2"></i>Cetak Laporan
                </button>
                @endif

                <a class="nav-link {{ Route::is('penyewaan.index') ? 'active' : '' }}"
                   href="{{ route('penyewaan.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                    Reservasi
                </a>

                <a class="nav-link {{ Route::is('riwayat-reservasi') ? 'active' : '' }}"
                   href="{{ route('riwayat-reservasi') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                    Riwayat Reservasi
                </a>


                {{-- ================= ADMIN ONLY ================= --}}
                @if(Auth::user()->role == 2)

                <div class="sb-sidenav-menu-heading">Manajemen Penyewa</div>

                <a class="nav-link {{ Route::is('admin.user') ? 'active' : '' }}" href="{{ route('admin.user') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Daftar Penyewa
                </a>

                <a class="nav-link {{ Route::is('superuser.admin') ? 'active' : '' }}" href="{{ route('superuser.admin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                    Manajemen Admin
                </a>

                <div class="sb-sidenav-menu-heading">Manajemen Produk</div>

                <a class="nav-link {{ Route::is('alat.index') ? 'active' : '' }}" href="{{ route('alat.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-campground"></i></div>
                    Alat
                </a>

                <a class="nav-link {{ Route::is('kategori.index') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Kategori
                </a>

                <a class="nav-link {{ Route::is('services.index') ? 'active' : '' }}" href="{{ route('services.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-concierge-bell"></i></div>
                    Layanan
                </a>

                @endif

            </div>
        </div>

       <div class="sb-sidenav-footer text-center">
    <div class="small text-muted">Login sebagai</div>


    <span class="badge bg-danger mt-1" style="font-size: 10px;">
        {{ Auth::user()->role == 2 ? 'Admin' : 'Kasir' }}
    </span>
</div>

    </nav>
</div>

    <!-- ================= CONTENT ================= -->
    <div id="layoutSidenav_content">

        <main class="pb-4">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="py-3 bg-light border-top mt-auto">
            <div class="container-fluid px-4 text-center">
                <small class="text-muted">
                    &copy; {{ date('Y') }} Sewa Alat Camping
                </small>
            </div>
        </footer>

    </div>
</div>

<!-- ================= MODAL CETAK ================= -->
<div class="modal fade" id="cetakLaporanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content shadow">

            <div class="modal-header">
                <h5 class="modal-title">Cetak Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('cetak') }}" method="GET" target="_blank">

                    <label class="mb-1">Dari</label>
                    <input type="date" class="form-control mb-3" name="dari">

                    <label class="mb-1">Sampai</label>
                    <input type="date" class="form-control mb-3" name="sampai">

                    <button class="btn btn-success w-100">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- ================= SCRIPT ================= -->

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Core JS -->
<script src="{{ asset('js/adminscripts.js') }}"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Datatables -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
<script src="{{ asset('js/datatables.js') }}"></script>

{{--  TEMPAT SCRIPT PER PAGE (WAJIB UNTUK CHART) --}}
@stack('scripts')

</body>
</html>