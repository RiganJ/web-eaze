@extends('layouts.cms')

@section('title', 'Tambah Pesanan Detailing')
@section('page-title', 'Tambah Pesanan Detailing')

@section('content')
<div class="order-page-created">

  <div class="order-card">

    <div class="order-card-header">
      <div>
        <h3>Tambah Pesanan Detailing</h3>
        <p>Input data pesanan detailing customer</p>
      </div>

      <a href="{{ url('admin/detailing/orders') }}" class="btn-back">
        ← Kembali
      </a>
    </div>

    <form method="POST" action="{{ route('detailing.orders.store') }}" class="order-form">
      @csrf

      <div class="form-grid">
        <div class="form-group">
          <label>Nama Customer</label>
          <input type="text" name="customer_name" placeholder="Nama customer" required>
        </div>

        <div class="form-group">
          <label>Layanan Detailing</label>
          <select name="service_id" id="service" required>
            <option value="">Pilih Layanan</option>
            @foreach($services as $s)
              <option value="{{ $s->id }}"
                      data-unit="{{ $s->unit }}"
                      data-price="{{ $s->price }}">
                {{ $s->name }} – Rp {{ number_format($s->price, 0, ',', '.') }} / {{ $s->unit }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Jenis Detailing</label>
          <select name="type" id="type" required>
            <option value="">Pilih Jenis</option>
            <option value="kiloan">Kiloan</option>
            <option value="satuan">Satuan</option>
          </select>
        </div>

        <div class="form-group">
          <label>Berat Detailing (kg)</label>
          <input type="number" name="weight" step="0.1" min="0.1" placeholder="Contoh: 2.5" required>
        </div>

        <div class="form-group hidden" id="qty-group">
          <label>Jumlah (pcs)</label>
          <input type="number" name="qty" min="1" placeholder="Jumlah item">
        </div>

        <div class="form-group">
          <label>Jenis Kendaraan</label>
          <select name="vehicle_type" id="vehicle_type" required>
            <option value="mobil">Mobil</option>
            <option value="motor">Motor</option>
          </select>
        </div>

        <div class="form-group">
          <label>Total</label>
          <input type="number" name="total" id="total" step="0.01" readonly>
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
<link rel="stylesheet" href="{{ asset('css/laundry-order-form.css') }}">
@endpush
