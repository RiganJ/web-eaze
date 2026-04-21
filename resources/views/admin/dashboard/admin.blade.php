@extends('layouts.cms')

@section('title','Dashboard')
@section('page-title','Dashboard Admin')

@section('content')

<div class="super-dashboard">

  <!-- TOP STATS -->
  <div class="stats-grid">
    <div class="stat-card">
      <i class="fa-solid fa-wallet"></i>
      <div>
        <h3>Rp {{ number_format($totalIncome,0,',','.') }}</h3>
        <span>Total Pendapatan</span>
      </div>
    </div>

    <div class="stat-card">
      <i class="fa-solid fa-users"></i>
      <div>
        <h3>{{ $totalAdmins }}</h3>
        <span>Total Admin</span>
      </div>
    </div>

    <div class="stat-card">
      <i class="fa-solid fa-file-invoice"></i>
      <div>
        <h3>{{ $totalOrders }}</h3>
        <span>Total Transaksi</span>
      </div>
    </div>

    <div class="stat-card">
      <i class="fa-solid fa-chart-line"></i>
      <div>
        <h3>{{ $monthlyGrowth >= 0 ? '+'.$monthlyGrowth : $monthlyGrowth }}%</h3>
        <span>Pertumbuhan Bulanan</span>
      </div>
    </div>
  </div>

  <!-- SERVICE REPORT (4 Layanan) -->
  <div class="service-report">
    @php
      $services = [
        'Laundry' => 'fa-shirt',
        'Home Cleaning' => 'fa-broom',
        'Car Wash' => 'fa-car-side',
        'Motor' => 'fa-motorcycle'
      ];
    @endphp

    @foreach($services as $name => $icon)
    <div class="service-card {{ Str::slug($name,'') }}">
      <i class="fa-solid {{ $icon }}"></i>
      <h4>{{ $name }}</h4>
      <p>Admin: {{ $serviceStats[$name]['admin'] ?? '-' }}</p>
      <span>{{ $serviceStats[$name]['completed'] ?? 0 }} Pesanan Selesai</span>
    </div>
    @endforeach
  </div>

  @if(auth()->check() && auth()->user()->role === 'super_admin')
  <div class="card" style="margin-bottom: 28px;">
    <h5><i class="fa-solid fa-tags"></i> Kelola Harga Layanan</h5>
    <p style="color:#94a3b8; margin:0 0 16px;">Atur harga semua layanan dari satu halaman khusus super admin.</p>
    <a href="{{ route('admin.layanan.prices') }}" class="btn edit" style="text-decoration:none; display:inline-block;">
      Buka Manajemen Harga
    </a>
  </div>
  @endif

  <!-- MAIN CONTENT GRID -->
  <div class="content-grid">

    <!-- CHART PENDAPATAN -->
    <div class="card">
      <h5><i class="fa-solid fa-chart-pie"></i> Statistik Pendapatan Mingguan</h5>
      <canvas id="incomeChart"></canvas>
    </div>

    <!-- ADMIN REPORT -->
    <div class="card">
      <h5><i class="fa-solid fa-clipboard-list"></i> Laporan Admin</h5>
      @foreach($adminReports as $admin => $data)
      <div class="report-item">
        <strong>{{ $admin }} ({{ $data['service'] }})</strong>
        <span>Rp {{ number_format($data['income'],0,',','.') }}</span>
      </div>
      @endforeach
    </div>

    <!-- ACCOUNT MANAGEMENT -->
    <div class="card full">
      <h5><i class="fa-solid fa-user-gear"></i> Kelola Akun</h5>
      <table class="account-table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Role</th>
            <th>Layanan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td>{{ $user->service ?? '-' }}</td>
            <td>
              <span class="badge {{ $user->is_active ? 'active' : 'inactive' }}">
                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
              </span>
            </td>
            <td>
              <button class="btn edit">Edit</button>
              <button class="btn delete">Hapus</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>

</div>

@push('scripts')
<script>
new Chart(document.getElementById('incomeChart'), {
    type:'line',
    data:{
        labels: @json($labels),
        datasets:[{
            label: 'Pendapatan',
            data: @json($incomeData),
            tension:0.4,
            borderWidth:3,
            fill:true,
            backgroundColor:'rgba(255,165,0,0.2)',
            borderColor:'orange'
        }]
    },
    options:{
        plugins:{legend:{display:false}},
        scales:{
            x:{grid:{display:false}},
            y:{grid:{color:'rgba(0,0,0,0.1)'}}
        }
    }
});
</script>
@endpush

@endsection
