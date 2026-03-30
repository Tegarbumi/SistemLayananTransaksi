@extends('admin.main')
@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card shadow">
                <div class="card-body" style="overflow: auto">

                    <table id="dataTable">
                        <thead>
                            <tr>
                                <th>No. Invoice</th>
                                <th>Tanggal Reservasi</th>
                                <th>User</th>
                                <th>Total</th>
                                <th>Detail</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($penyewaan as $item)

                                {{-- 🔥 ROW MERAH JIKA ADA DENDA --}}
                                <tr class="{{ $item->status == 4 ? 'table-danger' : '' }}">

                                    <td>
                                        {{ $item->no_invoice }}

                                        {{-- STATUS --}}
                                        @if ($item->status == 1)
                                            <span class="badge bg-warning">Perlu Ditinjau</span>
                                        @elseif ($item->status == 2)
                                            <span class="badge bg-info">Belum Bayar</span>
                                        @elseif ($item->status == 3)
                                            <span class="badge bg-success">Sudah Bayar</span>
                                        @elseif ($item->status == 4)
                                            <span class="badge bg-danger">Ada Denda</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ date('D, d M Y H:i', strtotime($item->created_at)) }}

                                        {{-- 🔥 PESAN DENDA --}}
                                        @if ($item->status == 4)
                                            <br>
                                            <small class="text-danger fw-bold">
                                                ⚠️ Menunggu pembayaran denda
                                            </small>
                                        @endif
                                    </td>

                                    <td>
                                        <b>{{ $item->user->name }}</b> 
                                        ({{ $item->user->email }})
                                    </td>

                                    <td>
                                        @money($item->total) 
                                        &nbsp;

                                        <span class="badge bg-secondary">
                                            {{ $item->order->count() }} Alat
                                        </span>

                                        {{-- 🔥 TOTAL DENDA --}}
                                        @if ($item->status == 4 && $item->dendas->count() > 0)
                                            <br>
                                            <span class="badge bg-danger">
                                                Denda: @money($item->dendas->sum('jumlah'))
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('penyewaan.detail',['id' => $item->id]) }}" 
                                           class="btn btn-outline-primary position-relative">

                                            Detail

                                            {{-- 🔥 NOTIF BULAT (TETAP ADA) --}}
                                            @if ($item->bukti != null && $item->status != 4 && $item->status != 3)
                                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                                <span class="visually-hidden">bukti bayar</span>
                                            </span>
                                            @endif

                                        </a>
                                    </td>

                                </tr>

                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        {{-- 🔥 KALENDER (TIDAK DIUBAH) --}}
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-body">
                    @include('partials.kalender')
                </div>
            </div>
        </div>

    </div>
</div>
@endsection