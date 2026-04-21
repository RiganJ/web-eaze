@extends('layouts.cms')

@section('title', 'Order ' . $config['label'])
@section('page-title', 'Order ' . $config['label'])

@section('content')

<div class="order-wrapper">
  <div class="order-card">

    <div class="order-header">
      <div>
        <h4>{{ $config['label'] }}</h4>
        <small>Daftar order masuk</small>
      </div>
    </div>

    @if($orders->count())
      <div class="table-responsive">
        <table id="ordersTable" class="order-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Order Code</th>
              <th>Customer</th>
              <th>No. HP</th>
              <th>Layanan</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>Total</th>
            </tr>
          </thead>
         <tbody>
@foreach($orders as $order)
@if(!in_array($order->{$config['status_column']}, ['selesai','diambil']))
    @continue
@endif

<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $order->order_code }}</td>
    <td>{{ $order->{$config['customer_column']} }}</td>
    <td>{{ $order->phone ?? '-' }}</td>
    <td>{{ $config['label'] }}</td>
    <td>
        <span class="status status-done">
            {{ ucfirst($order->{$config['status_column']}) }}
        </span>
    </td>
    <td>{{ \Carbon\Carbon::parse($order->{$config['date_column']})->format('d M Y') }}</td>
    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
</tr>
@endforeach
</tbody>

        </table>
      </div>
    @else
      <div class="empty-state">
        <i class="fa-solid fa-box-open"></i>
        <p>Belum ada order untuk layanan ini</p>
      </div>
    @endif

  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
  $('#ordersTable').DataTable({
    pageLength: 10,
    lengthChange: false,
    ordering: true,
    language: {
      search: "Cari order:",
      paginate: {
        previous: "‹",
        next: "›"
      },
      info: "Menampilkan _START_ - _END_ dari _TOTAL_ order",
      zeroRecords: "Order tidak ditemukan"
    }
  });
});
</script>
@endpush
