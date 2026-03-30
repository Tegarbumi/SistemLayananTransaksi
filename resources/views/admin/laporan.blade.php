<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <div class="row mb-4">
        <h4>Laporan Reservasi & Pemasukan</h4>
        <small>
            from <b>{{ date('D, d M Y', strtotime(request('dari'))) }}</b>
            to <b>{{ date('D, d M Y', strtotime(request('sampai'))) }}</b>
        </small>
    </div>

    <table class="table table-bordered">

        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Penyewa</th>
                <th>Total Sewa</th>
                <th>Denda</th>
                <th>Grand Total</th>
                <th>Detail</th>
            </tr>
        </thead>

        <tbody>

        @foreach($laporan as $item)

        @php
            $grand = $item->total + $item->total_denda;
        @endphp

        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>{{ $item->no_invoice }}</td>

            <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>

            <td>{{ $item->name }}</td>

            <td class="text-end">
                <b>@money($item->total)</b>
            </td>

            <td class="text-end text-danger">
                <b>@money($item->total_denda)</b>
            </td>

            <td class="text-end text-success">
                <b>@money($grand)</b>
            </td>

            <td>
                <button class="btn btn-sm btn-primary"
                    data-bs-toggle="collapse"
                    data-bs-target="#detail{{ $item->id }}">
                    Detail
                </button>
            </td>
        </tr>

        {{-- 🔽 DETAIL ITEM --}}
        <tr class="collapse" id="detail{{ $item->id }}">
            <td colspan="8">

                <table class="table table-sm table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>Item</th>
                            <th>Jenis</th>
                            <th class="text-end">Harga</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($item->items as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $d->nama_alat ?? $d->nama_layanan ?? '-' }}
                            </td>

                            <td>
                                @if($d->nama_alat)
                                    <span class="badge bg-primary">Alat</span>
                                @elseif($d->nama_layanan)
                                    <span class="badge bg-success">Layanan</span>
                                @endif
                            </td>

                            <td class="text-end">
                                @money($d->harga)
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </td>
        </tr>

        @endforeach

        {{-- TOTAL --}}
        @php
            $totalSewa = $laporan->sum('total');
            $totalDenda = $laporan->sum('total_denda');
            $grandTotal = $totalSewa + $totalDenda;
        @endphp

        <tr class="table-light">
            <td colspan="4"></td>

            <td class="text-end">
                <b>@money($totalSewa)</b>
            </td>

            <td class="text-end text-danger">
                <b>@money($totalDenda)</b>
            </td>

            <td class="text-end text-success">
                <b>@money($grandTotal)</b>
            </td>

            <td></td>
        </tr>

        </tbody>

    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
window.print()
</script>

</body>
</html>