@extends('member.main')
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


<!-- KATALOG ALAT -->

<div class="card shadow">

<div class="card-header">
<b>Katalog Produk</b>
</div>

<div class="card-body">

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

<small>{{ $item->deskripsi }}</small>

<hr>

<div class="d-flex justify-content-between">
<small><b>@money($item->harga24)</b></small>
<small><b>24 jam</b></small>
</div>

</div>

<div class="card-footer">

<form action="{{ route('cart.store',['id'=>$item->id,'userId'=>Auth::user()->id]) }}" method="POST">
@csrf

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



<!-- PANEL KERANJANG

<div id="keranjang">

<div class="card border-0 rounded-0">

<div class="card-header bg-dark text-white d-flex justify-content-between">

<b>Keranjang</b>

<button class="btn btn-sm btn-light"
onclick="toggleCart()">
X
</button>

</div> -->


<div class="card-body">

<div class="list-group">

@forelse ($carts as $item)

<div class="list-group-item">

<div class="d-flex justify-content-between">

<h6>

@if($item->alat_id)

    {{ $item->alat->nama_alat }}

@elseif($item->service_id)

    {{ $item->service->nama_layanan }}

@endif

</h6>

<b>@money($item->harga)</b>

</div>

<div class="d-flex justify-content-between">

<p>

@if($item->alat_id)

    {{ $item->durasi }} Jam

@elseif($item->service_id)

    {{ $item->service->durasi }}

@endif

</p>

<form action="{{ route('cart.destroy',['id'=>$item->id]) }}" method="POST">

@method('DELETE')
@csrf

<button class="btn btn-danger btn-sm">
<i class="fas fa-trash"></i>
</button>

</form>

</div>

</div>

@empty

<p class="text-center">
Keranjang masih kosong
</p>

@endforelse

</div>

</div>


<div class="card-body">

<div class="d-flex justify-content-between mb-2">

<b>Total</b>

<b>@money($total)</b>

</div>


<form action="{{ route('order.create') }}" method="POST">

@csrf

<small>Tanggal Pengambilan</small>

<input type="date"
name="start_date"
class="form-control mb-2"
required>


<small>Jam Pengambilan</small>

<input type="time"
name="start_time"
class="form-control mb-3"
required>


<button type="submit"
class="btn btn-success w-100"
{{ (Auth::user()->cart->count() == 0) ? 'disabled' : '' }}>

Checkout

</button>

</form>

</div>

</div>

</div>

@endsection