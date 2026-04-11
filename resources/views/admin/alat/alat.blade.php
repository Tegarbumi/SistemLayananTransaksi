@extends('admin.main')
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Manajemen Alat</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Manajemen Alat</li>
        </ol>

        <div class="row">

            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="col-lg">
                <div class="card shadow mb-4">

                    <div class="card-header">
                        Alat
                    </div>

                    <div class="card-body">

                        <a class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#tambahAlat">
                            Tambah Alat
                        </a>

                        <div class="dropdown" style="float:right;">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Filter Kategori
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('alat.index') }}">
                                        Semua
                                    </a>
                                </li>

                                @foreach ($categories as $cat)
                                <li>
                                    <a class="dropdown-item" href="{{ route('alat.index',['id'=>$cat->id]) }}">
                                        {{ $cat->nama_kategori }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <form action="">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Cari Alat" name="search">
                                <button class="btn btn-primary">Cari</button>
                            </div>
                        </form>

                    </div>

                    <div class="card-body" style="max-height:500px; overflow:scroll;">
                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">

                            @foreach ($alats as $alat)

                            <div class="col-6">

                               <div class="card h-100 d-flex flex-column">

                                    <img class="card-img-top"
                                    src="{{ url('') }}/images/{{ $alat->gambar }}"
                                    style="height:140px; object-fit:cover;">

                                    <div class="card-body">
                                        <span class="badge bg-warning">
                                            {{ $alat->category->nama_kategori }}
                                        </span>

                                        <h6 class="card-title">
                                            {{ $alat->nama_alat }}
                                        </h6>
                                    </div>

                                    <ul class="list-group list-group-flush">

                                        <li class="list-group-item">
                                            @money($alat->harga24)
                                            <span class="badge bg-light text-dark float-end">
                                                1 Hari
                                            </span>
                                        </li>

                                        <li class="list-group-item">
                                            @money($alat->harga48)
                                            <span class="badge bg-light text-dark float-end">
                                                2 Hari
                                            </span>
                                        </li>

                                        <li class="list-group-item">
                                            @money($alat->harga72)
                                            <span class="badge bg-light text-dark float-end">
                                                3 Hari
                                            </span>
                                        </li>

                                    </ul>

                                    <div class="card-footer mt-auto">
                                        <div class="btn-group">
                                            <a href="{{ route('alat.edit',['id'=>$alat->id]) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>


<!-- Modal Tambah Alat -->

<div class="modal fade" id="tambahAlat">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Alat</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="{{ route('alat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <input type="text"
                            name="nama"
                            class="form-control"
                            placeholder="Nama Alat"
                            required>
                    </div>

                    <div class="mb-3">
                        <select class="form-select" name="kategori" required>

                            @foreach ($categories as $cat)

                            <option value="{{ $cat->id }}">
                                {{ $cat->nama_kategori }}
                            </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <textarea class="form-control"
                            name="deskripsi"
                            rows="3"
                            placeholder="Deskripsi singkat">
                        </textarea>
                    </div>

                    <div class="mb-3">

                        <span class="form-text">
                            Harga ditulis angka saja
                        </span>

                        <!-- 24 JAM -->
                        <input type="number"
                            name="harga24"
                            class="form-control mb-2"
                            placeholder="Harga / 1 Hari"
                            required>

                        <!-- 48 JAM -->
                        <input type="number"
                            name="harga48"
                            class="form-control mb-2"
                            placeholder="Harga / 2 Hari">

                        <!-- 72 JAM -->
                        <input type="number"
                            name="harga72"
                            class="form-control"
                            placeholder="Harga / 3 Hari">

                    </div>

                    <div class="mb-3">
                        <span class="form-text">
                            Upload Gambar Alat
                        </span>

                        <input type="file"
                            name="gambar"
                            class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Tambah
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection