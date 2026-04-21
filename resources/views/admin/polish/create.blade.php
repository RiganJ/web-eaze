@extends('layouts.cms')

@section('title', 'Tambah Pesanan Polish')
@section('page-title', 'Tambah Pesanan Polish')

@section('content')
<div class="order-page-created">

  <div class="order-card">

    <div class="order-card-header">
      <div>
        <h3>Tambah Pesanan Polish</h3>
        <p>Input data pesanan polish customer</p>
      </div>

      <a href="{{ url('admin/polish/orders') }}" class="btn-back">
        ← Kembali
      </a>
    </div>

    <form method="POST" action="{{ route('polish.orders.store') }}" class="order-form">
      @csrf

      <div class="form-grid">
        <div class="form-group">
          <label>Nama Customer</label>
          <input type="text" name="customer_name" placeholder="Nama customer" required>
        </div>

        <div class="form-group">
          <label>Layanan Polish</label>
          <select name="service_id" id="service" required>
            <option value="">Pilih Layanan</option>
            @foreach($services as $s)
              <option value="{{ $s->id }}">
                {{ $s->name }} – Rp {{ number_format($s->price, 0, ',', '.') }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Jenis Kendaraan</label>
          <select name="vehicle_type" required>
            <option value="">Pilih Jenis</option>
            <option value="mobil">Mobil</option>
            <option value="motor">Motor</option>
          </select>
        </div>
      </div>

      <div class="form-footer">
        <button type="submit" class="btn-submit-create">
          💾 Simpan Pesanan
        </button>
      </div>

    </form>

  </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/polish-order-form.css') }}">
@endpush
