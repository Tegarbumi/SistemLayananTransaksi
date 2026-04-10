@extends('admin.main')
@section('content')

<div class="container-fluid px-4">
<div class="row">
<div class="col-md-12 mt-4">
<div class="card">


{{-- ================= HEADER ================= --}}
<div class="card-header">
<div class="d-flex justify-content-between align-items-center">

<a href="{{ route('penyewaan.index') }}">
<i class="fas fa-arrow-left"></i>
</a>

<h5 class="mb-0">Detail Reservasi</h5>

<div>
@if ($status == 1)
<span class="badge bg-warning">Perlu Ditinjau</span>
@elseif ($status == 2)
<span class="badge bg-info">Belum Bayar</span>
@elseif ($status == 3)
<span class="badge bg-success">Sudah Bayar</span>
@elseif ($status == 4)
<span class="badge bg-warning">Menunggu Pembayaran Denda</span>
@elseif ($status == 5)
<span class="badge bg-success">Selesai</span>
@endif
</div>

</div>
</div>

{{-- ================= BODY ================= --}}
<div class="card-body" style="overflow:auto">

{{-- ================= INFO ================= --}}
<table class="table table-success">
<tr>
<th>No. Invoice</th>
<td>{{ $payment->no_invoice ?? '-' }}</td>
</tr>

<tr>
<th>Penyewa</th>
<td>
<b>{{ $detail->first()->user->name }}</b>
({{ $detail->first()->user->email }})
</td>
</tr>

<tr>
<th>Telepon</th>
<td>{{ $detail->first()->user->telepon }}</td>
</tr>

<tr>
<th>Tanggal Pengambilan</th>
<td>{{ date('d M Y H:i', strtotime($detail->first()->starts)) }}</td>
</tr>
</table>

{{-- ================= TABLE ITEM ================= --}}
<form action="{{ route('acc',['paymentId'=>$payment->id]) }}" method="POST" id="formAcc">
@csrf
@method('PATCH')

<table class="table">
<thead>
<tr>
<th width="120">
No <br>

@if ($status == 1)
<input type="checkbox" id="checkAll"> 
<small>Pilih Semua</small>
@endif

</th>
<th>Item</th>
<th>Pengembalian</th>
<th>Harga</th>
</tr>
</thead>

<tbody>

@foreach($detail as $item)
<tr class="{{ ($item->status == 3) ? 'table-danger' : '' }}">

<td>
{{ $loop->iteration }}

@if ($status == 1)
<br>
<input type="checkbox" 
       class="itemCheckbox" 
       name="order[]" 
       value="{{ $item->id }}">
@endif
</td>

<td>
@if($item->alat_id)
<b>{{ $item->alat->nama_alat }}</b><br>

<span class="badge bg-warning">
{{ $item->alat->category->nama_kategori }}
</span>

<span class="badge bg-secondary">
{{ $item->durasi }} Jam
</span>

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

<tr>
<td>
@if ($status == 1)
<div class="d-flex gap-2">

<button type="submit" class="btn btn-success">
ACC Terpilih
</button>

<button type="button" class="btn btn-danger" onclick="submitReject()">
Reject Terpilih
</button>

</div>
@endif
</td>

<td></td>
<td class="text-end"><b>Total</b></td>
<td class="text-end">
    <b>@money($detail->where('status', '!=', 3)->sum('harga'))</b>
</td>
</tr>

</tbody>
</table>
</form>

{{-- ================= SCRIPT CHECKBOX ================= --}}
<script>
document.addEventListener("DOMContentLoaded", function() {

    const checkAll = document.getElementById("checkAll");
    const checkboxes = document.querySelectorAll(".itemCheckbox");

    if(checkAll){
        checkAll.addEventListener("click", function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        checkboxes.forEach(cb => {
            cb.addEventListener("click", function() {
                const allChecked = document.querySelectorAll('.itemCheckbox:checked').length === checkboxes.length;
                checkAll.checked = allChecked;
            });
        });
    }

});

function submitReject(){
    if(confirm("Yakin ingin reject item terpilih?")){
        let form = document.getElementById('formAcc');
        form.action = "{{ route('reject',['paymentId'=>$payment->id]) }}";
        form.submit();
    }
}
</script>

{{-- ================= DENDA ================= --}}
@if($payment && $payment->dendas->count() > 0)

@php
$denda = $payment->dendas->first();
@endphp

<div class="card mt-4 border-danger">
<div class="card-header bg-danger text-white">
<b>Informasi Denda</b>
</div>

<div class="card-body">
<table class="table table-bordered">
<tr>
<th>Jenis</th>
<th>Keterangan</th>
<th>Jumlah</th>
<th>Status</th>
</tr>

<tr>
<td><span class="badge bg-warning text-dark">{{ ucfirst($denda->jenis_denda) }}</span></td>
<td>{{ $denda->keterangan }}</td>
<td><b>@money($denda->jumlah)</b></td>
<td>
@if($denda->status_pembayaran == 'belum_bayar')
<span class="badge bg-danger">Belum Bayar</span>
@else
<span class="badge bg-success">Sudah Bayar</span>
@endif
</td>
</tr>
</table>
</div>
</div>

@endif

{{-- ================= INPUT DENDA ================= --}}
@if ($status == 3)
<form action="{{ route('selesai',['id'=>$payment->id]) }}" method="POST">
@csrf
@method('PATCH')

<div class="mb-3">
<label>Denda (Rp)</label>
<input type="number" name="denda" id="dendaInput" class="form-control">
</div>

<div class="mb-3">
<label>Jenis Denda</label>
<select name="jenis_denda" id="jenisDenda" class="form-control" disabled>
<option value="">-- Pilih --</option>
<option value="telat">Keterlambatan</option>
<option value="rusak">Kerusakan</option>
<option value="hilang">Hilang</option>
</select>
</div>

<div class="mb-3">
<label>Keterangan</label>
<input type="text" name="keterangan" class="form-control">
</div>

<button type="submit" class="btn btn-primary mb-4">
Proses Pengembalian
</button>

</form>

<script>
document.getElementById('dendaInput').addEventListener('input', function() {
    let jenis = document.getElementById('jenisDenda');
    jenis.disabled = (this.value == '' || this.value == 0);
});
</script>
@endif

{{-- ================= ACC DENDA ================= --}}
@if ($status == 4)

<div class="alert alert-warning mt-3">
Menunggu pembayaran denda
</div>

@if($payment->bukti_denda)
<img src="{{ url('images/denda/'.$payment->bukti_denda) }}" width="400">
@endif

<form action="{{ route('denda.acc',['id'=>$payment->id]) }}" method="POST">
@csrf
@method('PATCH')
<button class="btn btn-success">ACC Pembayaran Denda</button>
</form>

@endif

{{-- ================= BUKTI & KTP (TIDAK DIHAPUS) ================= --}}
@if ($status != 1)

<div class="accordion mt-4">

<div class="accordion-item">
<button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#bukti">
Bukti Pembayaran
</button>

<div id="bukti" class="accordion-collapse collapse show">
<div class="accordion-body">

@if ($payment->bukti)
<form action="{{ route('accbayar',['id'=>$payment->id]) }}" method="POST">
@csrf
@method('PATCH')

<button class="btn btn-success mb-3" {{ ($status >= 3) ? 'disabled' : '' }}>
ACC Pembayaran
</button>
</form>

<img src="{{ url('images/evidence/'.$payment->bukti) }}" width="400">
@else
Belum upload bukti
@endif

</div>
</div>
</div>

<div class="accordion-item">
<button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#ktp">
Jaminan KTP
</button>

<div id="ktp" class="accordion-collapse collapse">
<div class="accordion-body">

@if ($payment->jaminan_ktp)
<img src="{{ url('images/ktp/'.$payment->jaminan_ktp) }}" width="400">
@else
Belum upload KTP
@endif

</div>
</div>
</div>

</div>

@endif

</div>
</div>
</div>
</div>
</div>

@endsection