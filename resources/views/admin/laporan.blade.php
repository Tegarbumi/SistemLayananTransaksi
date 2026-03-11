<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <div class="row mb-4">
        <h4>Laporan Reservasi dan Pemasukan</h4>
        <small>
            from <b>{{ date('D, d M Y', strtotime(request('dari'))) }}</b>
            to <b>{{ date('D, d M Y', strtotime(request('sampai'))) }}</b>
        </small>
    </div>

    <div class="row">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Reservasi</th>
                    <th>Item</th>
                    <th>Jenis</th>
                    <th>Penyewa</th>
                    <th>Harga</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($laporan as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ date('D, d M Y', strtotime($item->tanggal)) }}
                    </td>

                    <td>

                        {{-- Jika Alat --}}
                        @if(isset($item->nama_alat))
                            {{ $item->nama_alat }}

                        {{-- Jika Layanan --}}
                        @elseif(isset($item->nama_layanan))
                            {{ $item->nama_layanan }}

                        @else
                            -
                        @endif

                    </td>

                    <td>

                        @if(isset($item->nama_alat))
                            <span class="badge bg-primary">Alat</span>

                        @elseif(isset($item->nama_layanan))
                            <span class="badge bg-success">Layanan</span>

                        @endif

                    </td>

                    <td>
                        {{ $item->name }}
                    </td>

                    <td style="text-align:right">
                        <b>@money($item->harga)</b>
                    </td>

                </tr>

                @endforeach

                <tr>
                    <td colspan="5"></td>
                    <td style="text-align:right">
                        <b>@money($total)</b>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

<script>
window.print()
</script>

</body>
</html>