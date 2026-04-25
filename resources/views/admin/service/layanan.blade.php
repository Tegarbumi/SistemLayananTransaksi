@extends('admin.main')
@section('content')
<main>
<div class="container-fluid px-4">

<h1 class="mt-4">Kelola Layanan</h1>

<ol class="breadcrumb mb-4">
<li class="breadcrumb-item active">Kelola Layanan</li>
</ol>

<div class="row">

@if (session()->has('message'))
<div class="alert alert-success alert-dismissible fade show">
{{ session('message') }}
<button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="col-lg">

<div class="card shadow mb-4">

<div class="card-header">
Layanan
</div>

<div class="card-body">

<a class="btn btn-primary mb-4"
data-bs-toggle="modal"
data-bs-target="#tambahLayanan">
Tambah Layanan
</a>

</div>

<div class="card-body" style="max-height:500px; overflow:scroll;">

<div class="row row-cols-sm-2 row-cols-lg-4 g-3">

@foreach ($services as $service)

<div class="col">

<div class="card h-100">

<img class="card-img-top"
src="{{ url('') }}/images/services/{{ $service->gambar }}">

<div class="card-body">

<h6 class="card-title">
{{ $service->nama_layanan }}
</h6>

<p class="text-muted">
{{ $service->durasi }}
</p>

</div>

<ul class="list-group list-group-flush">

<li class="list-group-item">

@money($service->harga)

</li>

</ul>

<div class="card-footer">
    <div class="btn-group">

        <!-- Tombol Edit -->
        <a href="{{ route('services.edit',['id'=>$service->id]) }}"
        class="btn btn-sm btn-primary">
            Edit
        </a>

        <!-- Tombol Hapus -->
        <form action="{{ route('services.destroy',['id'=>$service->id]) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus layanan ini?');">

            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-sm btn-danger ms-1">
                Hapus
            </button>

        </form>

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


<!-- MODAL TAMBAH LAYANAN -->

<div class="modal fade" id="tambahLayanan">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Tambah Layanan</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<form action="{{ route('services.store') }}"
method="POST"
enctype="multipart/form-data">

@csrf

<div class="mb-3">

<input type="text"
name="nama_layanan"
class="form-control"
placeholder="Nama Layanan"
required>

</div>

<div class="mb-3">

<textarea class="form-control"
name="deskripsi"
rows="3"
placeholder="Deskripsi Layanan"></textarea>

</div>

<div class="mb-3">

<input type="number"
name="harga"
class="form-control"
placeholder="Harga Layanan"
required>

</div>

<div class="mb-3">

<input type="text"
name="durasi"
class="form-control"
placeholder="Durasi Layanan (misal: 1 hari)">

</div>

<div class="mb-3">

<span class="form-text">
Upload Gambar Layanan
</span>

<input type="file"
name="gambar"
class="form-control">

</div>

<div class="modal-footer">

<button type="submit"
class="btn btn-primary">
Tambah
</button>

</div>

</form>

</div>

</div>
</div>
</div>

@endsection