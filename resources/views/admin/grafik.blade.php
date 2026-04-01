@extends('admin.main')

@section('content')

<div class="container-fluid px-4 mt-4">

<h4>Dashboard Pemasukan</h4>

<div class="card p-4">
    <canvas id="chartKeuangan"></canvas>
</div>

</div>

@endsection


{{-- SCRIPT MASUK KE STACK --}}
@push('scripts')

<script>

const labels = @json($data->pluck('tanggal'));
const totalSewa = @json($data->pluck('total_sewa'));
const totalDenda = @json($data->pluck('total_denda'));

const grandTotal = totalSewa.map((val, i) => val + totalDenda[i]);

new Chart(document.getElementById('chartKeuangan'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Total Sewa',
                data: totalSewa,
                borderWidth: 2
            },
            {
                label: 'Denda',
                data: totalDenda,
                borderWidth: 2
            },
            {
                label: 'Grand Total',
                data: grandTotal,
                borderWidth: 3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
});

</script>

@endpush