<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<title>Reservasi Baru</title>

</head>

<body>

<div class="container-fluid px-4">

<div class="row mt-4">
<div class="col-12">
<a href="{{ route('admin.user') }}" class="btn btn-primary">Kembali</a>
</div>
</div>

<div class="row mb-4 mt-2">
<div class="col-12">
<h4>Buat Reservasi untuk <b>{{ $user->name }}</b></h4>
</div>
</div>

<div class="row">

<div class="col col-md-8 col-sm-12">

<div class="card shadow h-100" style="max-height:100%;overflow:auto">

<div class="card-header">
<small class="text-muted">klik nama alat untuk melihat detail</small>
</div>

<div class="card-body">

<div class="row row-cols-sm-2 row-cols-lg-4 g-2">

@foreach ($alat as $item)

<div class="col">

<div class="card h-100">

<img src="{{ url('') }}/images/{{ $item->gambar }}"
style="height:100px;object-fit:cover;filter:brightness(40%)">

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

<small>{{ $item->deskripsi }}</small>

</div>

<div class="card-footer">

<form action="{{ route('cart.store',['id'=>$item->id,'userId'=>$user->id]) }}" method="POST">
@csrf

<div class="d-block">

<button type="submit" class="btn btn-success w-100 mt-2" name="btn" value="24">
<i class="fas fa-shopping-cart"></i>
@money($item->harga24) <b>24 jam</b>
</button>

<button type="submit" class="btn btn-success w-100 mt-2" name="btn" value="12">
<i class="fas fa-shopping-cart"></i>
@money($item->harga12) <b>12 jam</b>
</button>

<button type="submit" class="btn btn-success w-100 mt-2" name="btn" value="6">
<i class="fas fa-shopping-cart"></i>
@money($item->harga6) <b>6 jam</b>
</button>

</div>

</form>

</div>

</div>

</div>

@endforeach

</div>
</div>
</div>
</div>

<div class="col col-md-4 col-sm-12">

<div class="card shadow">

<div class="card-header">
<b>Keranjang</b>
<span class="badge bg-secondary">{{ $user->cart->count() }}</span>
</div>

<div class="card-body">

<div class="list-group">

@foreach ($cart as $item)

<div class="list-group-item list-group-item-action">

<div class="d-flex w-100 justify-content-between">

<h6 class="mb-1">

@if($item->alat_id)
{{ $item->alat->nama_alat }}

@elseif($item->service_id)
{{ $item->service->nama_layanan }}

@endif

</h6>

<b>@money($item->harga)</b>

</div>

<div class="d-flex w-100 justify-content-between">

<p class="mb-1">

@if($item->alat_id)
{{ $item->durasi }} Jam
@else
Layanan
@endif

</p>

<form action="{{ route('cart.destroy',['id'=>$item->id]) }}" method="POST">
@method('DELETE')
@csrf

<button style="background:none;border:none" type="submit">
<i class="fas fa-trash" style="color:gray"></i>
</button>

</form>

</div>

</div>

@endforeach

</div>

</div>

<div class="card-body">

<div class="d-flex w-100 justify-content-between mb-2">

<b>Total</b>
<b>@money($detail->sum('harga'))</b>

</div>

<small>Tanggal Ambil</small>

<form action="{{ route('admin.createorder',['userId'=>$user->id]) }}" method="POST">

@csrf

<div class="d-flex w-100 justify-content-center mb-4">

<input type="date" name="start_date" class="form-control" required>

<input type="time" name="start_time" class="form-control" required>

</div>

<button type="submit" class="btn btn-success w-100">
Checkout
</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>