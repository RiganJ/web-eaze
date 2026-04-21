@extends('layouts.cms')

@section('title','Pesanan HomeClean')


@section('content')

<div class="order-wrapper">
  <div class="order-card">

    <div class="order-header">
      <div>
        <h4>Pesanan HomeClean</h4>
        <small>Daftar order masuk</small>
      </div>

      <!-- Tombol Tambah Order -->
      <a href="{{ route('admin.homecleaning.orders.create') }}" class="btn-modern btn-primary-modern">
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
              <th>WhatsApp</th>
              <th>Jenis Layanan</th>
              <th>Jumlah/Unit</th>
              <th>Total</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
@foreach($orders as $o)
<tr>
  <td>{{ $loop->iteration }}</td>
  <td>{{ $o->invoice_code }}</td>
  <td>{{ $o->customer_name }}</td>
  <td>{{ $o->customer_phone ?? '-' }}</td>
<td>{{ $o->items_summary }}</td>



  <td>{{ $o->items_count }} item: {{ $o->quantity_summary }}</td>

  <td>Rp {{ number_format($o->total,0,',','.') }}</td>

  <td>
    <span class="badge badge-{{ $o->status }}">
      {{ ucfirst($o->status) }}
    </span>
  </td>

  <td>{{ \Carbon\Carbon::parse($o->order_date)->format('d M Y') }}</td>

<td class="action-cell">

    <!-- DETAIL -->
    <a href="{{ route('admin.homecleaning.orders.show', $o->id) }}" 
       class="btn-modern btn-outline-modern">
       <i class="fa-solid fa-magnifying-glass"></i>
       Detail
    </a>

    <!-- UPDATE STATUS -->
    <form method="POST"
          action="{{ route('admin.homecleaning.orders.status', $o->id) }}">
        @csrf

        @php
            $statusIcons = [
                'menunggu' => 'fa-hourglass-half',
                'pending' => 'fa-hourglass-half',
                'proses' => 'fa-gear',
                'selesai' => 'fa-circle-check',
                'diambil' => 'fa-hand-holding',
                'batal' => 'fa-circle-xmark'
            ];
        @endphp

        <div style="display:flex; align-items:center; gap:6px;">
            <i class="fa-solid {{ $statusIcons[$o->status] ?? 'fa-circle-question' }}"></i>

            <select name="status"
                    onchange="this.form.submit()"
                    class="status-select status-{{ $o->status }}">
                <option value="menunggu" {{ $o->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="pending" {{ $o->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="proses" {{ $o->status == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ $o->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="diambil" {{ $o->status == 'diambil' ? 'selected' : '' }}>Diambil</option>
                <option value="batal" {{ $o->status == 'batal' ? 'selected' : '' }}>Batal</option>
            </select>
        </div>

    </form>

</td> 

</tr>
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
<link rel="stylesheet" href="{{ asset('css/homecleaning-orders.css') }}">
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
