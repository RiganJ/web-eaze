@extends('layouts.cms')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')

@section('content')

<div class="order-wrapper">
  <div class="order-card">

    {{-- HEADER --}}
    <div class="order-header">
      <div>
        <h4>Laporan Keuangan</h4>
        <small>Ringkasan pendapatan dari order berstatus <b>DONE</b></small>
      </div>
    </div>

    {{-- SUMMARY --}}
    <div class="stats-grid">

      <div class="stat-card">
        <i class="fa-solid fa-wallet"></i>
        <div class="stat-info">
          <h3>Rp {{ number_format($totalIncome,0,',','.') }}</h3>
          <span>Total Pendapatan</span>
        </div>
      </div>

      <div class="stat-card">
        <i class="fa-solid fa-receipt"></i>
        <div class="stat-info">
          <h3>{{ $totalOrder }}</h3>
          <span>Total Order Done</span>
        </div>
      </div>

    </div>

    {{-- FILTER --}}
    <form method="GET" class="order-filter">
      <div class="filter-group">
        <input type="date" name="start_date" value="{{ $start }}">
        <input type="date" name="end_date" value="{{ $end }}">
        <button class="btn btn-primary">
          <i class="fa-solid fa-filter"></i> Filter
        </button>
      </div>
    </form>

    {{-- TABLE --}}
    @if($orders->count())
      <div class="table-wrapper">
        <table class="order-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Order Code</th>
              <th>Tanggal</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>


                <td class="code">{{ $order->order_code }}</td>

                <td>
                  {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                </td>

                <td class="price">
                  Rp {{ number_format($order->total_price,0,',','.') }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

     

    @else
      <div class="empty-state">
        <i class="fa-solid fa-chart-line"></i>
        <p>Belum ada data keuangan</p>
      </div>
    @endif

  </div>
</div>

@endsection
