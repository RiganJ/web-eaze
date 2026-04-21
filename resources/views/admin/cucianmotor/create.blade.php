@extends('layouts.cms')

@section('title', 'Tambah Pesanan Cucian Motor')
@section('page-title', 'Tambah Pesanan Cucian Motor')

@section('content')
<div class="order-page-created">

  <div class="order-card">

    <div class="order-card-header">
      <div>
        <h3>Tambah Pesanan Cucian Motor</h3>
        <p>Input data pesanan cucian motor customer</p>
      </div>

<a href="{{ route('cucianmotor.orders') }}" 
   class="btn-modern btn-outline-modern">
   <i class="fa-solid fa-arrow-left"></i>
   Kembali
</a>
    </div>

    <form method="POST" action="{{ route('cucianmotor.orders.store') }}" class="order-form">
      @csrf

      <div class="form-grid">
        <div class="form-group">
          <label>Nama Customer</label>
          <input type="text" name="customer_name" placeholder="Nama customer" required>
        </div>
           <div class="form-group">
          <label>No WhatsApp Customer</label>
          <input type="text"
                 name="customer_phone"
                 placeholder="628xxxxxxxxxx"
                 required>
          <small>Gunakan format 628xxxxxxxxxx</small>
        </div>

        <div class="form-group">
          <label>Layanan Cucian Motor</label>
          <select name="service_id" id="service" required>
            <option value="">Pilih Layanan</option>
            @foreach($services as $s)
              <option value="{{ $s->id }}">
                {{ $s->name }} – Rp {{ number_format($s->price, 0, ',', '.') }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-footer">
<button type="submit" 
        class="btn-modern btn-primary-modern">
   <i class="fa-solid fa-floppy-disk"></i>
   Simpan Pesanan
</button>
      </div>

    </form>

  </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/carwash-order-form.css') }}">
@endpush
