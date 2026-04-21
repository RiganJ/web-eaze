@extends('layouts.cms')

@section('title','Pesanan Polish')
@section('page-title','Pesanan Polish')

@section('content')

<div class="order-wrapper">
  <div class="order-card">

    <div class="order-header">
      <div>
        <h4>Pesanan Polish</h4>
        <small>Daftar order masuk Polish</small>
      </div>

      <!-- Tombol Tambah Order -->
      <a href="{{ route('polish.orders.create') }}" class="btn btn-primary">
        Tambah Order
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
              <th>Jenis Kendaraan</th>
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
              <td>{{ $o->service->name ?? '-' }}</td>
              <td>{{ ucfirst($o->vehicle_type) }}</td>
              <td>Rp {{ number_format($o->price,0,',','.') }}</td>
              <td>
                <span class="badge badge-{{ $o->status }}">
                    {{ ucfirst($o->status) }}
                </span>
              </td>
              <td>{{ \Carbon\Carbon::parse($o->order_date)->format('d M Y') }}</td>
              <td>
                <form method="POST"
                      action="{{ route('polish.orders.status', $o->id) }}">
                  @csrf
                  <select name="status" onchange="this.form.submit()">
                    <option value="pending" {{ $o->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="proses" {{ $o->status == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ $o->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ $o->status == 'batal' ? 'selected' : '' }}>Batal</option>
                  </select>
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
<link rel="stylesheet" href="{{ asset('css/polish-orders.css') }}">
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
