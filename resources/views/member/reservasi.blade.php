@extends('member.main')
@section('container')

{{-- ================= NOTIF ================= --}}
@if(session('notif'))
<div class="modal fade" id="notifModal">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header bg-primary text-white">
<h5 class="modal-title"><i class="fas fa-bell"></i> Notifikasi</h5>
</div>

<div class="modal-body text-center">
<h6>{{ session('notif') }}</h6>
</div>

<div class="modal-footer">
<button class="btn btn-primary w-100" data-bs-dismiss="modal">OK</button>
</div>

</div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    new bootstrap.Modal(document.getElementById('notifModal')).show();
});
</script>
@endif


<div class="container">

{{-- ================= RESERVASI ================= --}}
<div class="card shadow rounded-4 mb-4">

<div class="card-header bg-dark text-white d-flex justify-content-between">
<h5><i class="fas fa-box"></i> Reservasi Aktif</h5>
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table align-middle">

<thead class="table-light">
<tr>
<th>Tanggal</th>
<th>Total</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse ($reservasi as $item)

@php
    $hasDenda = $item->dendas->count() > 0;
@endphp

<tr class="{{ $hasDenda ? 'table-danger' : '' }}">

<td>
@if($item->order->first())
{{ date('d M Y H:i', strtotime($item->order->first()->starts)) }}
@else
-
@endif
</td>

<td>

<b>@money($item->total)</b>

<br>

<span class="badge bg-secondary">
{{ $item->order->count() }} Item
</span>

<br>

{{-- STATUS --}}
@if ($item->status == 1)
<span class="badge bg-warning">Menunggu</span>
@elseif ($item->status == 2)
<span class="badge bg-info">Belum Bayar</span>
@elseif ($item->status == 3)
<span class="badge bg-success">Sudah Bayar</span>
@elseif ($item->status == 4)
<span class="badge bg-danger">Denda</span>
@endif

{{-- 🔥 PESAN DENDA --}}
@if($hasDenda && $item->status == 4)
<div class="alert alert-danger mt-2 p-2">
<i class="fas fa-exclamation-triangle"></i>
Anda dikenakan denda, silahkan lakukan pembayaran agar jaminan bisa dikembalikan
</div>
@endif

</td>

<td>
<a class="btn btn-sm btn-primary rounded-pill"
href="{{ route('order.detail',['id' => $item->id]) }}">
<i class="fas fa-eye"></i> Detail
</a>
</td>

</tr>

@empty

<tr>
<td colspan="3" class="text-center py-4">

<i class="fas fa-box-open fa-2x mb-2 text-muted"></i>

<p class="text-muted">Belum ada reservasi</p>

<a href="{{ route('member.index') }}" class="btn btn-success">
Mulai Sekarang
</a>

</td>
</tr>

@endforelse

</tbody>
</table>

</div>
</div>
</div>


{{-- ================= RIWAYAT ================= --}}
<div class="card shadow rounded-4">

<div class="card-header bg-secondary text-white">
<h5><i class="fas fa-history"></i> Riwayat</h5>
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table align-middle">

<thead class="table-light">
<tr>
<th>Tanggal</th>
<th>Total</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach ($riwayat as $r)

<tr>

<td>
@if($r->order->first())
{{ date('d M Y H:i', strtotime($r->order->first()->starts)) }}
@else
-
@endif
</td>

<td>
<b>@money($r->total)</b>

<br>

<span class="badge bg-secondary">
{{ $r->order->count() }} Alat
</span>

<span class="badge bg-dark">
Selesai
</span>
</td>

<td>
<a class="btn btn-sm btn-outline-primary rounded-pill"
href="{{ route('order.detail',['id' => $r->id]) }}">
<i class="fas fa-eye"></i> Detail
</a>
</td>

</tr>

@endforeach

</tbody>
</table>

</div>

</div>
</div>

</div>

@endsection