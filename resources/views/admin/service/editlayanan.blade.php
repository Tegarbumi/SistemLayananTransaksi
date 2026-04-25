@extends('admin.main')
@section('content')
<main>

<div class="container-fluid px-4">

<div class="row mt-4">

<div class="col">

<div class="card mb-4">

<div class="card-header">

<a class="link-dark" href="{{ route('services.index') }}">
<i class="fas fa-arrow-left"></i> Kembali
</a>

| Detail untuk Layanan "{{ $service->nama_layanan }}"

</div>

<div class="card-body">

<form action="{{ route('services.update',['id'=>$service->id]) }}"
method="POST"
enctype="multipart/form-data">

@method('PATCH')
@csrf

<input class="form-control form-control-lg mb-4"
type="text"
name="nama_layanan"
value="{{ $service->nama_layanan }}"
required>

<div class="mb-3">

<textarea class="form-control"
name="deskripsi"
rows="3"
placeholder="Deskripsi Layanan">{{ $service->deskripsi }}</textarea>

</div>

<div class="mb-3">

<span class="form-text">
Harga ditulis angka saja
</span>

<div class="input-group">

<span class="input-group-text">Rp</span>

<input type="number"
name="harga"
value="{{ $service->harga }}"
class="form-control"
required>

</div>

</div>

<div class="mb-3">

<input type="text"
name="durasi"
value="{{ $service->durasi }}"
class="form-control"
placeholder="Durasi Layanan">

</div>

<div class="mb-3">

<span class="form-text">Upload Gambar Layanan</span>

<input type="file"
name="gambar"
class="form-control">

</div>

<div class="row mt-4">

<div class="col-lg-8"></div>

<div class="col-lg-4">

<button class="btn btn-success"
type="submit"
style="float:right">

Simpan Perubahan

</button>

</div>

</div>

</form>

</div>


<div class="card-body">

<form action="{{ route('services.destroy',['id'=>$service->id]) }}"
method="POST">

@method('DELETE')
@csrf


</form>

</div>

</div>

</div>

</div>

</div>

</main>
@endsection