@extends('admin.main')
@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="alert alert-warning">
                        Halaman reservasi yang sudah selesai
                    </div>

                    <table id="dataTable">
                        <thead>
                            <tr>
                                <th>No. Invoice</th>
                                <th>Tanggal Reservasi</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Detail</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($penyewaan as $item)

                                {{--  ROW MERAH JIKA ADA DENDA --}}
                                <tr class="{{ $item->status == 4 ? 'table-danger' : '' }}">

                                    <td>
                                        {{ $item->no_invoice }}

                                        {{--  BADGE STATUS --}}
                                        @if($item->status == 4)
                                            <span class="badge bg-danger">Ada Denda</span>
                                        @else
                                            <span class="badge bg-secondary">Selesai</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ date('D, d M Y H:i', strtotime($item->created_at)) }}

                                        {{--  PESAN DENDA --}}
                                        @if($item->status == 4)
                                            <br>
                                            <small class="text-danger fw-bold">
                                                ⚠️ Ada denda, belum dibayar
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

                                        {{--  TOTAL DENDA --}}
                                        @if($item->status == 4 && $item->dendas->count() > 0)
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
</div>
@endsection