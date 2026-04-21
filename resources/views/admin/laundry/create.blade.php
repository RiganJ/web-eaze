@extends('layouts.cms')

@section('title','Tambah Pesanan Laundry')
@section('page-title','Tambah Pesanan Laundry')

@section('content')

<div class="order-page-created">
  <div class="order-card">
    <div class="order-card-header">
      <div>
        <h3>Tambah Pesanan Laundry</h3>
        <p>Input beberapa item pesanan laundry dalam satu form</p>
      </div>

      <a href="{{ route('admin.laundry.orders') }}" class="btn-modern btn-outline-modern">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
      </a>
    </div>

    @if ($errors->any())
      <div style="margin-bottom:16px; padding:12px 16px; border-radius:10px; background:#fff1f2; color:#b42318;">
        <strong>Periksa kembali input pesanan.</strong>
        <ul style="margin:8px 0 0 18px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.laundry.orders.store') }}" class="order-form" id="laundryOrderForm">
      @csrf

      <div class="form-grid">
        <div class="form-group">
          <label>Nama Customer</label>
          <input type="text" name="customer_name" placeholder="Nama customer" value="{{ old('customer_name') }}" required>
        </div>

        <div class="form-group">
          <label>No WhatsApp Customer</label>
          <input type="text" name="customer_phone" placeholder="628xxxxxxxxxx" value="{{ old('customer_phone') }}" required>
          <small>Gunakan format 628xxxxxxxxxx</small>
        </div>
      </div>

      <div id="laundry-items">
        <div class="laundry-item-card" data-subtotal="0" style="border:1px solid #eee; border-radius:14px; padding:16px; margin-bottom:16px;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <h4 style="margin:0;">Item 1</h4>
            <button type="button" class="btn-modern btn-outline-modern remove-item-btn" style="display:none;">Hapus</button>
          </div>

          <div class="form-grid">
            <div class="form-group">
              <label>Layanan Laundry</label>
              <select name="items[0][service_id]" class="laundry-service" required>
                <option value="">Pilih Layanan</option>
                @foreach($services as $s)
                  <option value="{{ $s->id }}" data-price="{{ $s->price }}" data-duration="{{ $s->duration }}" {{ old('items.0.service_id') == $s->id ? 'selected' : '' }}>
                    {{ $s->name }}@if($s->type) ({{ $s->type }})@endif - Rp {{ number_format($s->price,0,',','.') }} / {{ $s->unit }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Estimasi Durasi</label>
              <input type="text" class="item-duration" readonly placeholder="Pilih layanan terlebih dahulu">
            </div>

            <div class="form-group">
              <label>Jenis Laundry</label>
              <select name="items[0][type]" class="laundry-type" required>
                <option value="">Pilih Jenis</option>
                <option value="kiloan" {{ old('items.0.type') === 'kiloan' ? 'selected' : '' }}>Kiloan</option>
                <option value="satuan" {{ old('items.0.type') === 'satuan' ? 'selected' : '' }}>Satuan</option>
              </select>
            </div>

            <div class="form-group weight-group" style="display:none;">
              <label>Berat Cucian (kg)</label>
              <input type="number" name="items[0][weight]" class="laundry-weight" step="0.1" min="0.1" placeholder="Contoh: 2.5" value="{{ old('items.0.weight') }}">
            </div>

            <div class="form-group qty-group" style="display:none;">
              <label>Jumlah (pcs)</label>
              <input type="number" name="items[0][qty]" class="laundry-qty" min="1" placeholder="Contoh: 3" value="{{ old('items.0.qty') }}">
            </div>

            <div class="form-group">
              <label>Subtotal</label>
              <input type="text" class="item-subtotal" readonly value="Rp 0">
            </div>
          </div>
        </div>
      </div>

      <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin:16px 0;">
        <button type="button" class="btn-modern btn-outline-modern" id="addLaundryItemBtn">
          <i class="fa-solid fa-plus"></i>
          Tambah Item
        </button>

        <div style="font-weight:700; font-size:18px;">
          Total Semua: <span id="laundryGrandTotal">Rp 0</span>
        </div>
      </div>

      <div class="form-footer">
        <button type="submit" class="btn-modern btn-primary-modern">
          <i class="fa-solid fa-floppy-disk"></i>
          Simpan Pesanan
        </button>
      </div>
    </form>
  </div>
</div>

<template id="laundry-item-template">
  <div class="laundry-item-card" data-subtotal="0" style="border:1px solid #eee; border-radius:14px; padding:16px; margin-bottom:16px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
      <h4 style="margin:0;">Item __NUMBER__</h4>
      <button type="button" class="btn-modern btn-outline-modern remove-item-btn">Hapus</button>
    </div>

    <div class="form-grid">
      <div class="form-group">
        <label>Layanan Laundry</label>
        <select name="items[__INDEX__][service_id]" class="laundry-service" required>
          <option value="">Pilih Layanan</option>
          @foreach($services as $s)
            <option value="{{ $s->id }}" data-price="{{ $s->price }}" data-duration="{{ $s->duration }}">
              {{ $s->name }}@if($s->type) ({{ $s->type }})@endif - Rp {{ number_format($s->price,0,',','.') }} / {{ $s->unit }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Estimasi Durasi</label>
        <input type="text" class="item-duration" readonly placeholder="Pilih layanan terlebih dahulu">
      </div>

      <div class="form-group">
        <label>Jenis Laundry</label>
        <select name="items[__INDEX__][type]" class="laundry-type" required>
          <option value="">Pilih Jenis</option>
          <option value="kiloan">Kiloan</option>
          <option value="satuan">Satuan</option>
        </select>
      </div>

      <div class="form-group weight-group" style="display:none;">
        <label>Berat Cucian (kg)</label>
        <input type="number" name="items[__INDEX__][weight]" class="laundry-weight" step="0.1" min="0.1" placeholder="Contoh: 2.5">
      </div>

      <div class="form-group qty-group" style="display:none;">
        <label>Jumlah (pcs)</label>
        <input type="number" name="items[__INDEX__][qty]" class="laundry-qty" min="1" placeholder="Contoh: 3">
      </div>

      <div class="form-group">
        <label>Subtotal</label>
        <input type="text" class="item-subtotal" readonly value="Rp 0">
      </div>
    </div>
  </div>
</template>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/laundry-order-form.css') }}">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('laundry-items');
    const template = document.getElementById('laundry-item-template').innerHTML;
    const addButton = document.getElementById('addLaundryItemBtn');
    const grandTotalEl = document.getElementById('laundryGrandTotal');

    function formatRupiah(value) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(value || 0));
    }

    function updateLabels() {
        container.querySelectorAll('.laundry-item-card').forEach((card, index) => {
            card.querySelector('h4').textContent = 'Item ' + (index + 1);
            card.querySelector('.remove-item-btn').style.display = index === 0 ? 'none' : 'inline-flex';
        });
    }

    function updateGrandTotal() {
        let total = 0;
        container.querySelectorAll('.laundry-item-card').forEach((card) => {
            total += Number(card.dataset.subtotal || 0);
        });
        grandTotalEl.textContent = formatRupiah(total);
    }

    function syncCard(card) {
        const service = card.querySelector('.laundry-service');
        const type = card.querySelector('.laundry-type');
        const weightGroup = card.querySelector('.weight-group');
        const qtyGroup = card.querySelector('.qty-group');
        const weightInput = card.querySelector('.laundry-weight');
        const qtyInput = card.querySelector('.laundry-qty');
        const durationInput = card.querySelector('.item-duration');
        const subtotalInput = card.querySelector('.item-subtotal');

        const selected = service.options[service.selectedIndex];
        const price = Number(selected?.dataset.price || 0);
        const duration = selected?.dataset.duration || '';

        durationInput.value = duration;
        weightGroup.style.display = type.value === 'kiloan' ? 'block' : 'none';
        qtyGroup.style.display = type.value === 'satuan' ? 'block' : 'none';

        weightInput.required = type.value === 'kiloan';
        qtyInput.required = type.value === 'satuan';

        if (type.value !== 'kiloan') weightInput.value = '';
        if (type.value !== 'satuan') qtyInput.value = '';

        let subtotal = 0;
        if (type.value === 'kiloan') subtotal = price * Number(weightInput.value || 0);
        if (type.value === 'satuan') subtotal = price * Number(qtyInput.value || 0);

        card.dataset.subtotal = subtotal;
        subtotalInput.value = formatRupiah(subtotal);
        updateGrandTotal();
    }

    function bindCard(card) {
        card.querySelector('.laundry-service').addEventListener('change', function () { syncCard(card); });
        card.querySelector('.laundry-type').addEventListener('change', function () { syncCard(card); });
        card.querySelector('.laundry-weight').addEventListener('input', function () { syncCard(card); });
        card.querySelector('.laundry-qty').addEventListener('input', function () { syncCard(card); });
        card.querySelector('.remove-item-btn').addEventListener('click', function () {
            card.remove();
            updateLabels();
            updateGrandTotal();
        });
        syncCard(card);
    }

    addButton.addEventListener('click', function () {
        const index = container.querySelectorAll('.laundry-item-card').length;
        const html = template.replaceAll('__INDEX__', index).replaceAll('__NUMBER__', index + 1);
        container.insertAdjacentHTML('beforeend', html);
        bindCard(container.lastElementChild);
        updateLabels();
    });

    container.querySelectorAll('.laundry-item-card').forEach(bindCard);
    updateLabels();
});
</script>
@endpush
