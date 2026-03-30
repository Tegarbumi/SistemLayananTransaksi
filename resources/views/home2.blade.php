<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<title>Sanss Adventure</title>
<link rel="icon" type="image/x-icon" href="assets/logo.jpg" />
<link href="css/styles.css" rel="stylesheet" />

<style>
/* BACKGROUND KIRI KANAN */
.hero-wrapper{
    background: linear-gradient(
        90deg,
        #054a3f 0%,
        #066b5d 30%,
        #08836e 50%,
        #0b6f63 70%,
        #043833 100%
    );

    padding:70px 0; /* jarak dari navbar */
}

/* HERO CARD */
.hero-slider{
    max-width:1100px;
    width:100%;
    margin:auto;

    min-height:420px;

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    border-radius:15px;

    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* overlay gelap */
.hero-slider::before{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.35);
    border-radius:15px;
}

/* isi hero */
.hero-slider > *{
    position:relative;
    z-index:2;
    color:white;
}

/* text */
.hero-slider h1{
    font-weight:600;
    letter-spacing:1px;
}

.hero-slider p{
    max-width:600px;
    margin:auto;
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-body-light">
<div class="container-fluid">

<!-- LOGO + TEXT -->
<a class="navbar-brand d-flex align-items-center" href="/">
<img src="{{ asset('assets/logo.jpg') }}" width="40" class="me-2">
<span class="fw-bold">SANSS ADVENTURE</span>
</a>

<!-- TOGGLE BUTTON -->
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03">
<span class="navbar-toggler-icon"></span>
</button>
      
<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <button type="button" class="btn btn-outline-light">
            <a class="nav-link active" aria-current="page" href="#filter">Katalog</a>
        </button>
        </li>
    <button type="button" class="btn btn-outline-light text-dark me-3" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
@if(Auth::check())
<li class="nav-item">
<a class="nav-link" href="{{ route('logout') }}">Logout</a>
</li>
@endif
</ul>
</div>
</div>
</nav>

<!-- HERO -->
 <div class="hero-wrapper">
<div id="heroSlider" class="text-center hero-slider">
<div class="col-md-5 p-lg-5 mx-auto my-3">
<h1 class="display-2 fw-normal">Sewa Alat Camping</h1>
<p class="fw-light">Tersedia Juga Beberapa Layanan Wisata Seperti Canyoneering, Flyingfox, Paket Camping Terima Beres, dan lainnya.</p>
@if (!Auth::check())
<button type="button" class="btn btn-outline-light mt-5" data-bs-toggle="modal" data-bs-target="#loginModal">Sewa Sekarang</button>
@endif
</div>
</div>
</div>

<!-- HERO -->
<!-- <section class="hero-section py-5">
<div class="container text-center">
<div class="carousel-wrapper mx-auto">
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-inner rounded shadow">
<div class="carousel-item active">
<img src="/images/slider/1.jpeg" class="d-block w-100 hero-img">
</div>
<div class="carousel-item">
<img src="/images/slider/2.jpeg" class="d-block w-100 hero-img">
</div>
<div class="carousel-item">
<img src="/images/slider/3.jpeg" class="d-block w-100 hero-img">
</div>
</div>
</div>
</div>
</div>
<button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
<span class="carousel-control-prev-icon"></span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
<span class="carousel-control-next-icon"></span>
</button>
</div>

<div class="hero-text mt-3">
<h1 class="display-4 fw-normal text-white">Sewa Alat Camping</h1>

<p class="fw-light text-white">
Tersedia Juga Beberapa Layanan Wisata Seperti Canyoneering,
Flyingfox, Paket Camping Terima Beres, dan lainnya.
</p>

@if (!Auth::check())
<button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">Login / Daftar</button>
@endif  

</div>

</div>

</section> -->

<div class="container">
@if (session()->has('registrasi'))
<div class="alert alert-warning alert-dismissible fade show">{{ session('registrasi') }}</div>
@endif
@if (session()->has('success_reset_password'))
<div class="alert alert-warning alert-dismissible fade show">{{ session('success_reset_password') }}</div>
@endif
@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}</div>
@endif

@if (Auth::check() && Auth::user()->role == 0)
<div class="alert alert-warning">
Anda telah login sebagai <b>{{ Auth::user()->name }}</b> <a class="btn btn-success" href="{{ route('member.index') }}">Mulai Menyewa</a>
</div>
@elseif (Auth::check() && Auth::user()->role != 0)
<div class="alert alert-warning">
Admin (<b>{{ Auth::user()->name }}</b>) <a class="btn btn-success" href="{{ route('admin.index') }}">Halaman Admin</a>
</div>
@endif

<div id= "filter" class="row mx-3">
@if (request()->get('search') == null)
<div class="d-flex w-100 justify-content-start mb-4 mt-2" style="overflow:auto">
<div class="btn-group">

<a class="btn {{ request('kategori')==null?'btn-secondary':'btn-outline-secondary' }}" href="/">
Semua
</a>

@foreach($categories as $cat)

<a class="btn {{ request('kategori')==$cat->id?'btn-secondary':'btn-outline-secondary' }}"
href="?kategori={{ $cat->id }}">
{{ $cat->nama_kategori }}
</a>

@endforeach

<a class="btn btn-outline-success" href="#layanan">
Layanan
</a>

</div>
</div>
@endif

<form>
<div class="input-group mb-3">
<input type="text" class="form-control" name="search" placeholder="Cari Produk">
<button class="btn btn-secondary">Cari</button>
</div>
</form>
</div>

<div class="row row-cols-sm-2 row-cols-lg-6 g-2 mb-5 mx-3">
@foreach($alats as $alat)
<div class="col-6">
<div class="card h-100">
<img class="card-img-top" src="{{ url('') }}/images/{{ $alat->gambar }}">
<div class="card-body">
<span class="badge bg-warning">{{ $alat->category->nama_kategori }}</span>
<h6>{{ $alat->nama_alat }}</h6>
</div>
<ul class="list-group list-group-flush">
<li class="list-group-item">@money($alat->harga24)<span class="float-end">24 Jam</span></li>
</ul>
<div class="card-footer">
<a href="{{ route('home.detail',['id'=>$alat->id]) }}" class="btn btn-sm btn-secondary">Detail</a>
</div>
</div>
</div>
@endforeach
</div>

</div>
<div id="layanan" class="container mb-5">

<h3 class="mb-4">Layanan Outdoor</h3>

<div class="row row-cols-1 row-cols-md-3 g-4">

@foreach($services as $service)

<div class="col">

<div class="card h-100 shadow-sm">

<img src="{{ asset('images/services/'.$service->gambar) }}"
class="card-img-top"
style="height:200px;object-fit:cover;">

<div class="card-body">

<h5>{{ $service->nama_layanan }}</h5>

<p>{{ $service->deskripsi }}</p>

<h6 class="text-success">
Rp {{ number_format($service->harga) }}
</h6>

@if(!Auth::check())

<button class="btn btn-outline-success w-100"
data-bs-toggle="modal"
data-bs-target="#loginModal">
Login untuk Reservasi
</button>

@else

<a href="{{ route('services.member') }}"
class="btn btn-success w-100">
Pesan Sekarang
</a>

@endif

</div>

</div>

</div>

@endforeach

</div>

</div>
<footer class="py-5 bg-dark">
    <div class="container px-4">
        <p class="m-0 text-center text-white">
            &copy; {{ date('Y') }} Sanss Adventure
        </p>
    </div>
</footer>

<!-- MODAL LOGIN (ASLI, TIDAK DIPINDAH) -->
<div class="modal fade" id="loginModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<div class="text-center mb-3">
<h5>Nikmati kemudahan dalam melakukan reservasi</h5>
<a href="{{ route('daftar') }}" class="btn btn-success">Daftar Sekarang</a>
</div>
<small>Sudah punya akun? silakan login</small>
@include('partials.login')
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const hero = document.getElementById("heroSlider");
const images = [
"/images/slider/1.jpeg",
"/images/slider/2.jpeg",
"/images/slider/3.jpeg"
];
let i = 0;
function slideBg(){
hero.style.backgroundImage = `url('${images[i]}')`;
i = (i+1) % images.length;
}
slideBg();
setInterval(slideBg,4000);
</script>

</body>
</html>
