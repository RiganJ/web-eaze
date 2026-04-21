@extends('layouts.cms')

@section('title','Dashboard Laundry')
@section('page-title','Dashboard Laundry')

@section('content')

<div class="homeclean-dashboard">

    <!-- TOP STATS -->
    <div class="stats-grid">

        <div class="stat-card">
            <i class="fa-solid fa-calendar-check"></i>
            <div>
                <h3>{{ $totalToday }}</h3>
                <span>Total Pesanan Hari Ini</span>
            </div>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-spinner"></i>
            <div>
                <h3>{{ $process }}</h3>
                <span>Pesanan Proses</span>
            </div>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-check-circle"></i>
            <div>
                <h3>{{ $done }}</h3>
                <span>Pesanan Selesai</span>
            </div>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-wallet"></i>
            <div>
                <h3>Rp {{ number_format($incomeToday) }}</h3>
                <span>Pendapatan Hari Ini</span>
            </div>
        </div>

    </div>

    <!-- MAIN CHART -->
    <div class="card mt-4">
        <h5><i class="fa-solid fa-chart-line"></i> Grafik Pendapatan Mingguan</h5>
        <canvas id="incomeChart"></canvas>
    </div>

</div>

@push('scripts')
<script>
const ctx = document.getElementById('incomeChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Pendapatan',
            data: @json($incomeData),
            borderColor: '#ff7a18',
            backgroundColor: 'rgba(255, 122, 24, 0.2)',
            tension: 0.4,
            fill: true,
            borderWidth: 3,
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { grid: { display: false } },
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' }
            }
        }
    }
});
</script>
@endpush

@endsection
