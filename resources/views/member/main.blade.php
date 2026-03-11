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

#keranjang{
position: fixed;
top:0;
right:-400px;
width:380px;
height:100%;
background:white;
box-shadow:-3px 0 10px rgba(0,0,0,0.2);
z-index:9999;
transition:0.3s;
overflow-y:auto;
}

#keranjang.active{
right:0;
}

</style>

</head>

<body>


<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container-fluid">

<a class="navbar-brand">
Hai Sobat Sanss
</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarMenu">


<ul class="navbar-nav ms-auto">

<li class="nav-item">

<a class="nav-link {{ Route::is('member.index') ? 'active' : '' }}"
href="{{ route('member.index') }}">

Explore

</a>

</li>

<li class="nav-item">

<a class="nav-link"
href="javascript:void(0)"
onclick="toggleCart()">

<i class="fas fa-shopping-cart"></i>
Keranjang

<span class="badge bg-secondary">

{{ Auth::user()->cart->count() }}

</span>

</a>

</li>

<li class="nav-item">

<a class="nav-link {{ Route::is('order.show') ? 'active' : '' }}"
href="{{ route('order.show') }}">

Reservasi

<span class="badge bg-secondary">

{{ Auth::user()->payment->count() }}

</span>

</a>

</li>

<li class="nav-item">

<a class="nav-link {{ Route::is('member.kalender') ? 'active' : '' }}"
href="{{ route('member.kalender') }}">

Kalender

</a>

</li>


<li class="nav-item dropdown">

<a class="nav-link dropdown-toggle"
href="#"
data-bs-toggle="dropdown">

{{ Auth::user()->name }}

</a>

<ul class="dropdown-menu dropdown-menu-end">

<li>

<a class="dropdown-item"
href="{{ route('akun.pengaturan') }}">

Pengaturan Akun

</a>

</li>

<li>

<a class="dropdown-item"
href="{{ route('logout') }}">

Logout

</a>

</li>

</ul>

</li>

</ul>

</div>

</div>

</nav>


<div class="container-fluid px-4 mt-4">

@yield('container')

</div>


<script>

function toggleCart(){

let cart = document.getElementById("keranjang");

cart.classList.toggle("active");

}

</script>


<script src="/js/datatables.js"></script>
<script src="/js/adminscripts.js"></script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

</body>
</html>