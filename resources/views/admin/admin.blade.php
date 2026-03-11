@extends('admin.main')

@section('content')

<style>
    .card-dashboard{
        color: #fff;
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }
    .card-dashboard h1{
        font-size: 3rem;
        font-weight: bold;
    }
    .bg-reservasi{
        background: linear-gradient(135deg,#1d976c,#93f9b9);
    }
    .bg-penyewa{
        background: linear-gradient(135deg,#2193b0,#6dd5ed);
    }
    .bg-alat{
        background: linear-gradient(135deg,#cc2b5e,#753a88);
    }
    .bg-kategori{
        background: linear-gradient(135deg,#ee9ca7,#ffdde1);
        color:#333;
    }
    .card-dashboard .card-footer{
        background: rgba(0,0,0,0.1);
        border-top: none;
    }
    .card-dashboard a{
        text-decoration: none;
        font-weight: 500;
    }
</style>

<main>
<div class="container-fluid px-4">
<div class="row mt-4">

    <!-- Reservasi -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card card-dashboard bg-reservasi shadow">
            <div class="card-body">
                <h1>{{ $total_penyewaan }}</h1>
                <div>Reservasi</div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a class="text-white" href="{{ route('penyewaan.index') }}">Kelola Reservasi</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <!-- Penyewa -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card card-dashboard bg-penyewa shadow">
            <div class="card-body">
                <h1>{{ $total_user }}</h1>
                <div>Penyewa</div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a class="text-white" href="{{ route('admin.user') }}">Kelola Penyewa</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <!-- Alat -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card card-dashboard bg-alat shadow">
            <div class="card-body">
                <h1>{{ $total_alat }}</h1>
                <div>Alat</div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a class="text-white" href="{{ route('alat.index') }}">Kelola Alat</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <!-- Kategori -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card card-dashboard bg-kategori shadow">
            <div class="card-body">
                <h1>{{ $total_kategori }}</h1>
                <div>Kategori</div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a class="text-dark" href="{{ route('kategori.index') }}">Kelola Kategori</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

</div>

<!-- Bagian bawah tetap -->
<div class="row mb-4">
    <div class="col col-lg-6 col-sm-12">
        @include('partials.kalender')
    </div>
    <div class="col col-lg-6 col-sm-12">
        <div class="card shadow mb-4 g-2">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Statistik
            </div>
            <div class="card-body">
                <h5><b>5 Penyewa Terbanyak</b></h5>
                <table class="table">
                    <thead>
                        <tr><th>#</th><th>Nama</th><th>Telepon</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($top_user as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="d-flex justify-content-between">
                                {{ $user->name }}
                                <span class="badge bg-secondary">{{ $user->payment_count }} Transaksi</span>
                            </td>
                            <td>{{ $user->telepon }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-body">
                <h5><b>5 Alat Terfavorit</b></h5>
                <table class="table">
                    <thead><tr><th>#</th><th>Alat</th></tr></thead>
                    <tbody>
                        @foreach ($top_products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="d-flex justify-content-between">
                                {{ $product->nama_alat }}
                                <span class="badge bg-secondary">{{ $product->order_count }} Reservasi</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</div>
</main>

@endsection
