<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Registrasi | Sanss Adventure</title>
<link rel="icon" type="image/x-icon" href="assets/logo.jpg" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<style>
body{
    background:#043833;
    min-height:100vh;
}
.register-card{
    background:#fff;
    border-radius:15px;
    box-shadow:0 20px 40px rgba(0,0,0,.3);
    overflow:hidden;
}
.register-left{
    background:url("/images/gunung.jpg") center/cover;
    min-height:100%;
    color:white;
}
.overlay{
    background:rgba(0,0,0,.6);
    height:100%;
    padding:40px;
}
.form-control{
    border-radius:10px;
}
.btn-register{
    border-radius:30px;
    font-weight:bold;
}
</style>
</head>

<body>


<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-10">
<div class="register-card row g-0">

<!-- LEFT BANNER -->
<div class="col-md-6 d-none d-md-block register-left">
<div class="overlay d-flex flex-column justify-content-center">
<h2 class="fw-bold">Sewa Peralatan Camping Lebih Mudah</h2>
<p>Harap lakukan registrasi terlebih dahulu untuk melakukan <a class=" text-decoration-none text-light fw-bold">reservasi</a>.</p>
</div>
</div>

<!-- FORM -->
<div class="col-md-6 p-5">
<h3 class="fw-bold mb-4">Buat Akun</h3>

<form action="{{ route('register.store') }}" method="POST">
@csrf

<div class="mb-3">
<label class="form-label">Nama Lengkap</label>
<input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" required>
</div>
@error('email')
<div class="text-danger small">{{ $message }}</div>
@enderror

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" required>
</div>
@error('password')
<div class="text-danger small">{{ $message }}</div>
@enderror

<div class="mb-3">
<label class="form-label">No Telepon (WhatsApp)</label>
<input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}" required>
</div>
@error('telepon')
<div class="text-danger small">{{ $message }}</div>
@enderror

<button type="submit" class="btn btn-success w-100 btn-register py-2 mt-3">
<i class="fas fa-user-plus"></i> Daftar Sekarang
</button>

</form>

<div class="text-center mt-3">
Sudah punya akun? <a href="{{ route('home') }}" class="fw-bold text-decoration-none">Login</a>
</div>

</div>

</div>
</div>
</div>
</div>

</body>
</html>
