<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Customer Area</title>
<link rel="icon" type="image/x-icon" href="/assets/logo.jpg"/>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>

body{
    background-color:#f5f7fb;
}

#keranjang{
    position: fixed;
    top:0;
    right:-400px;
    width:380px;
    height:100%;
    background:white;
    box-shadow:-3px 0 15px rgba(0,0,0,0.2);
    z-index:9999;
    transition:0.3s;
    overflow-y:auto;
    border-top-left-radius:15px;
    border-bottom-left-radius:15px;
}

#keranjang.active{
    right:0;
}

.navbar{
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.navbar-brand{
    font-weight:bold;
}

.badge{
    font-size:12px;
    padding:6px 8px;
    border-radius:20px;
}

.main-content{
    margin-top:20px;
}

.nav-link:hover{
    opacity:0.8;
}

</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container-fluid">

<a class="navbar-brand">
<i class="fas fa-mountain"></i> Sanss Adventure
</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarMenu">

<ul class="navbar-nav ms-auto align-items-center">

<li class="nav-item">
<a class="nav-link {{ Route::is('member.index') ? 'active fw-bold' : '' }}"
href="{{ route('member.index') }}">
<i class="fas fa-compass"></i> Explore
</a>
</li>

<li class="nav-item">
<a class="nav-link"
href="javascript:void(0)"
onclick="toggleCart()">

<i class="fas fa-shopping-cart"></i> Keranjang

<span class="badge bg-danger">
{{ Auth::user()->cart->count() }}
</span>

</a>
</li>

<li class="nav-item">
<a class="nav-link {{ Route::is('order.show') ? 'active fw-bold' : '' }}"
href="{{ route('order.show') }}">

<i class="fas fa-box"></i> Reservasi

<span class="badge bg-primary">
{{ Auth::user()->payment->count() }}
</span>

</a>
</li>

<li class="nav-item">
<a class="nav-link {{ Route::is('member.kalender') ? 'active fw-bold' : '' }}"
href="{{ route('member.kalender') }}">
<i class="fas fa-calendar-alt"></i> Kalender
</a>
</li>

<li class="nav-item dropdown ms-3">

<a class="nav-link dropdown-toggle d-flex align-items-center"
href="#"
data-bs-toggle="dropdown">

<i class="fas fa-user-circle me-2"></i>
{{ Auth::user()->name }}

</a>

<ul class="dropdown-menu dropdown-menu-end shadow">

<li>
<a class="dropdown-item" href="{{ route('akun.pengaturan') }}">
<i class="fas fa-cog"></i> Pengaturan Akun
</a>
</li>

<li><hr class="dropdown-divider"></li>

<li>
<a class="dropdown-item text-danger" href="{{ route('logout') }}">
<i class="fas fa-sign-out-alt"></i> Logout
</a>
</li>

</ul>

</li>

</ul>

</div>

</div>

</nav>


<!-- -->
<div id="keranjang">

<div class="card border-0 rounded-0">

<div class="card-header bg-dark text-white d-flex justify-content-between">

<b>Keranjang</b>

<button class="btn btn-sm btn-light"
onclick="toggleCart()">
X
</button>

</div>

<div class="card-body">

<div class="list-group">

@forelse ($carts ?? [] as $item)

<div class="list-group-item">

<div class="d-flex justify-content-between">

<h6>

@if($item->alat_id)
    {{ $item->alat->nama_alat }}
@elseif($item->service_id)
    {{ $item->service->nama_layanan }}
@endif

</h6>

@money($item->harga)

</div>

<div class="d-flex justify-content-between">

<p>

@if($item->alat_id)
    @if($item->durasi == 24)
        1 Hari
    @elseif($item->durasi == 48)
        2 Hari
    @elseif($item->durasi == 72)
        3 Hari
    @else
        {{ $item->durasi }} Jam
    @endif
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

@money($total ?? 0)

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


<!-- CONTENT -->
<div class="container-fluid px-4 main-content">

@yield('container')

</div>


<script>

function toggleCart(){
    let cart = document.getElementById("keranjang");
    if(cart){
        cart.classList.toggle("active");
    }
}

</script>

<script src="/js/datatables.js"></script>
<script src="/js/adminscripts.js"></script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

</body>
</html>