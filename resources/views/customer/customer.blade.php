@extends('customer.main')
@section('container')

@if (session()->has('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="">
<div class="input-group mb-3">
    <input type="text"
        class="form-control"
        placeholder="Cari Produk"
        name="search"
        value="{{ request('search') }}">

    <button class="btn btn-secondary">
        Cari
    </button>
</div>
</form>


<!-- KATALOG -->
<div class="card shadow">

<div class="card-header">
<b>Katalog Produk</b>
</div>

<div class="card-body d-flex flex-column">

<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">

@foreach ($alat as $item)

<div class="col">

<div class="card h-100">

<img class="card-img-top"
src="{{ url('') }}/images/{{ $item->gambar }}"
style="height:140px; object-fit:cover;">

<div class="card-body">

<span class="badge bg-warning">
{{ $item->category->nama_kategori }}
</span>

<br>

<b>
<a class="link-dark"
href="{{ route('home.detail',['id'=>$item->id]) }}">
{{ $item->nama_alat }}
</a>
</b>

<br>

<small style="
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;">
    {{ $item->deskripsi }}
</small>

<hr>

<!-- HARGA -->
<ul class="list-group list-group-flush">
<li class="list-group-item">
    @money($item->harga24)
    <span class="float-end">1 Hari</span>
</li>

<li class="list-group-item">
    @money($item->harga48)
    <span class="float-end">2 Hari</span>
</li>

<li class="list-group-item">
    @money($item->harga72)
    <span class="float-end">3 Hari</span>
</li>
</ul>

</div>

<div class="card-footer">

<form action="{{ route('cart.store',['id'=>$item->id,'userId'=>Auth::user()->id]) }}" method="POST">
@csrf

<select name="btn" class="form-select mb-2">
    <option value="24">1 Hari</option>
    <option value="48">2 Hari</option>
    <option value="72">3 Hari</option>
</select>

<button class="btn btn-primary w-100">
    <i class="fas fa-shopping-cart"></i>
    Tambah
</button>

</form>

</div>

</div>

</div>

@endforeach

</div>

</div>

</div>


<!-- KATALOG LAYANAN -->
<div class="card shadow mt-4">

<div class="card-header">
<b>Layanan Outdoor</b>
</div>

<div class="card-body">

<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">

@foreach ($services as $service)

<div class="col">

<div class="card h-100">

<img class="card-img-top"
src="{{ asset('images/services/'.$service->gambar) }}"
style="height:140px; object-fit:cover;">

<div class="card-body">

<span class="badge bg-success">
Layanan
</span>

<br>

<b>{{ $service->nama_layanan }}</b>

<br>

<small>{{ $service->deskripsi }}</small>

<hr>

<div class="d-flex justify-content-between">
<small><b>Rp {{ number_format($service->harga) }}</b></small>
<small><b>{{ $service->durasi }}</b></small>
</div>

</div>

<div class="card-footer">

<form action="{{ route('cart.service.store',['id'=>$service->id,'userId'=>Auth::user()->id]) }}" method="POST">
@csrf

<button class="btn btn-success w-100">
<i class="fas fa-shopping-cart"></i>
Tambah
</button>

</form>

</div>

</div>

</div>

@endforeach

</div>

</div>

</div>

@endsection