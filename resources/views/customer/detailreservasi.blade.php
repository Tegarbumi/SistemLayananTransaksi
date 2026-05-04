@extends('customer.main')
@section('container')

<div class="container">
 {{-- NOTIFIKASI BONUS --}}
    @if(session('bonus'))
        <div class="alert alert-success mt-3">
            {{ session('bonus') }}
        </div>
    @endif
    
<div class="card shadow rounded-4">

{{-- HEADER --}}
<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

<a href="{{ route('order.show') }}" class="text-white">
<i class="fas fa-arrow-left"></i>
</a>

<h5 class="mb-0">
<i class="fas fa-file-alt"></i> Detail Reservasi
</h5>

<div>

@if ($paymentStatus == 1)
<span class="badge bg-warning">Menunggu</span>
@elseif ($paymentStatus == 2)
<span class="badge bg-info">Belum Bayar</span>
@elseif ($paymentStatus == 3)
<span class="badge bg-success">Sudah Bayar</span>
@elseif ($paymentStatus == 4)
<span class="badge bg-danger">Menunggu Pembayaran Denda</span>
@elseif ($paymentStatus == 5)
<span class="badge bg-secondary">Selesai</span>
@endif

</div>

</div>


<div class="card-body">

{{-- ALERT --}}
@if ($paymentStatus == 3)
<div class="alert alert-success text-center">
<i class="fas fa-check-circle"></i>
Silakan ambil alat sesuai jadwal
</div>
@endif

@if ($paymentStatus == 4)
<div class="alert alert-danger text-center">
<i class="fas fa-exclamation-triangle"></i>
Anda memiliki denda, silakan lakukan pembayaran
</div>
@endif

@if ($paymentStatus == 5)
<div class="alert alert-secondary text-center">
<i class="fas fa-check"></i>
Transaksi selesai
</div>
@endif


{{-- INFO --}}
<div class="mb-3">

<p><b><i class="fas fa-calendar"></i> Tanggal Pengambilan:</b><br>
{{ date('d M Y H:i', strtotime($detail->first()->starts)) }}</p>

<p><b><i class="fas fa-receipt"></i> No. Invoice:</b><br>
{{ $detail->first()->payment->no_invoice }}</p>

</div>


{{-- TABLE --}}
<div class="table-responsive">

<table class="table align-middle">

<thead class="table-light">
<tr>
<th>No</th>
<th>Item</th>
<th>Pengembalian</th>
<th class="text-end">Harga</th>
</tr>
</thead>

<tbody>

@foreach($detail as $item)

<tr class="{{ ($item->status == 3) ? 'table-danger' : '' }}">

<td>{{ $loop->iteration }}</td>

<td>

@if($item->alat_id)

<a class="fw-bold text-dark" href="{{ route('home.detail',['id'=>$item->alat->id]) }}">
{{ $item->alat->nama_alat }}
</a>

<br>

<span class="badge bg-warning text-dark">
{{ $item->alat->category->nama_kategori }}
</span>

<span class="badge bg-secondary">
{{ $item->durasi }} Jam
</span>

@if($item->is_bonus)
<span class="badge bg-success">🎁 Bonus</span>
@endif
    
@elseif($item->service_id)

<b>{{ $item->service->nama_layanan }}</b><br>
<span class="badge bg-info">Layanan</span>

@endif

@if ($item->status === 3)
<span class="badge bg-danger">Ditolak</span>
@elseif ($item->status === 2)
<span class="badge bg-success">ACC</span>
@endif

</td>

<td>
{{ $item->ends ? date('d M Y H:i', strtotime($item->ends)) : '-' }}
</td>

<td class="text-end">
<b>@money($item->harga)</b>
</td>

</tr>

@endforeach

{{-- TOTAL SEWA --}}
<tr class="table-light">
<td colspan="3" class="text-end">
<b>Total Sewa</b>
</td>
<td class="text-end">
    <b>@money($detail->where('status', '!=', 3)->sum('harga'))</b>
</td>
</tr>

{{-- TOTAL DENDA --}}
@if(isset($totalDenda) && $totalDenda > 0)
<tr class="table-danger">
<td colspan="3" class="text-end">
<b>Total Denda</b>
</td>
<td class="text-end">
<b>@money($totalDenda)</b>
</td>
</tr>
@endif

{{-- GRAND TOTAL --}}
<tr class="table-dark text-white">
<td colspan="3" class="text-end">
<b>Grand Total</b>
</td>
<td class="text-end">
<b>
@money(
    $detail->where('status','!=',3)->sum('harga') + ($totalDenda ?? 0)
)
</b>
</td>
</tr>

</tbody>
</table>

</div>


{{-- CANCEL --}}
@if ($paymentStatus == 1)
<form action="{{ route('cancel',['id'=>$detail->first()->payment->id]) }}" method="POST">
@method('DELETE')
@csrf

<button type="submit"
onclick="return confirm('Batalkan reservasi ini?');"
class="btn btn-danger w-100 mt-2">

<i class="fas fa-times"></i> Cancel Reservasi

</button>
</form>
@endif


{{-- PEMBAYARAN AWAL --}}
@if ($paymentStatus == 2)

<div class="alert {{ ($detail->first()->payment->bukti == NULL) ? 'alert-primary' : 'alert-success'}} mt-3">

@if ($detail->first()->payment->bukti == NULL)

<p>Silahkan lakukan pembayaran ke:</p>
<h5><b>BRI 01230107645204</b></h5>
<h5><b>Mandiri 1730015056782</b></h5>
<p>a.n ADY SAMSU BAHTERA</p>

@else
<p><i class="fas fa-check"></i> Bukti sudah diupload, tunggu konfirmasi admin</p>
@endif

<button class="btn btn-success w-100 mt-2"
data-bs-toggle="modal"
data-bs-target="#bayarModal">

<i class="fas fa-upload"></i> Upload Bukti & KTP

</button>

</div>

@endif


{{-- BUKTI PEMBAYARAN AWAL --}}
@if ($paymentStatus >= 3)

<h5 class="mt-4"><i class="fas fa-image"></i> Bukti Pembayaran</h5>

<img src="{{ url('images/evidence/'.$bukti) }}"
class="img-fluid rounded shadow mb-3">

@if($detail->first()->payment->jaminan_ktp)
<h5><i class="fas fa-id-card"></i> Jaminan KTP</h5>

<img src="{{ url('images/ktp/'.$detail->first()->payment->jaminan_ktp) }}"
class="img-fluid rounded shadow">
@endif

@endif


{{-- ================= DENDA ================= --}}
@if($paymentStatus == 4)

<h5 class="mt-4 text-danger"><i class="fas fa-exclamation-circle"></i> Denda</h5>

<table class="table table-bordered">
<tr>
<th>Jenis</th>
<th>Jumlah</th>
<th>Keterangan</th>
</tr>

@foreach($detail->first()->payment->dendas as $denda)
<tr>
<td>{{ ucfirst($denda->jenis_denda) }}</td>
<td>@money($denda->jumlah)</td>
<td>{{ $denda->keterangan }}</td>
</tr>
@endforeach

</table>

{{-- UPLOAD DENDA --}}
@if(!$detail->first()->payment->bukti_denda)

<form action="{{ route('denda.bayar',['id'=>$paymentId]) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PATCH')

<div class="mb-3">
<label>Upload Bukti Pembayaran Denda</label>
<input type="file" name="bukti_denda" class="form-control" required>
</div>

<button class="btn btn-danger w-100">
Bayar Denda
</button>

</form>

@else

<div class="alert alert-warning mt-3">
Menunggu konfirmasi admin
</div>

<img src="{{ url('images/denda/'.$detail->first()->payment->bukti_denda) }}"
class="img-fluid rounded shadow">

@endif

@endif


</div>
</div>
</div>


{{-- MODAL PEMBAYARAN AWAL --}}
<div class="modal fade" id="bayarModal">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title"><i class="fas fa-upload"></i> Upload Bukti</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<form action="{{ route('bayar',['id'=>$paymentId]) }}"
method="POST"
enctype="multipart/form-data">

@method('PATCH')
@csrf

<label>Bukti Pembayaran</label>
<input type="file" name="bukti" class="form-control mb-3" required>

<label>Jaminan KTP</label>
<input type="file" name="jaminan_ktp" class="form-control mb-3" required>

<button class="btn btn-success w-100">
Upload
</button>

</form>

</div>

</div>
</div>
</div>

@endsection