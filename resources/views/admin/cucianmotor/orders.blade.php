@extends('layouts.cms')

@section('title','Pesanan Cucian Motor')

@section('content')

<div class="order-wrapper">
  <div class="order-card">

    <div class="order-header">
      <div>
        <h4>Pesanan Cucian Motor</h4>
        <small>Daftar order masuk</small>
      </div>

      <!-- Tombol Tambah Order -->
      <a href="{{ route('cucianmotor.orders.create') }}" class="btn-modern btn-primary-modern">
        <i class="fa-solid fa-plus"></i>Tambah Order
      </a>
    </div>

    @if($orders->count())
      <div class="table-responsive">
        <table id="ordersTable" class="order-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Pelanggan</th>
              <th>Jenis Layanan</th>
              <th>Harga</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $o)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $o->order_code }}</td>
              <td>{{ $o->customer_name }}</td>
              <td>{{ $o->customer_phone }}</td>

              <td>{{ $o->service->name ?? '-' }}</td>
              <td>
  @if($o->service)
    Rp {{ number_format($o->service->price,0,',','.') }}
  @else
    -
  @endif
</td>

              <td>
                <span class="badge badge-{{ $o->status }}">
                    {{ ucfirst($o->status) }}
                </span>
              </td>
              <td>{{ \Carbon\Carbon::parse($o->order_date)->format('d M Y') }}</td>
<td class="action-cell">

    <!-- DETAIL -->
    <a href="{{ route('cucianmotor.orders.show', $o->id) }}" 
       class="btn-modern btn-outline-modern">
       <i class="fa-solid fa-magnifying-glass"></i>
       Detail
    </a>

    <!-- UPDATE STATUS -->
    <form method="POST"
          action="{{ route('cucianmotor.orders.status', $o->id) }}">
        @csrf

        @php
            $statusIcons = [
                'pending' => 'fa-hourglass-half',
                'proses' => 'fa-gear',
                'selesai' => 'fa-circle-check',
                'batal' => 'fa-circle-xmark'
            ];
        @endphp

        <div style="display:flex; align-items:center; gap:6px;">
            <i class="fa-solid {{ $statusIcons[$o->status] }}"></i>

            <select name="status"
                    onchange="this.form.submit()"
                    class="status-select status-{{ $o->status }}">
                <option value="pending" {{ $o->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="proses" {{ $o->status == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ $o->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="batal" {{ $o->status == 'batal' ? 'selected' : '' }}>Batal</option>
            </select>
        </div>

    </form>

</td>            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="empty-state">
        <i class="fa-solid fa-box-open"></i>
        <p>Belum ada order masuk</p>
      </div>
    @endif

  </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cucianmotor-orders.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
@endpush

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
