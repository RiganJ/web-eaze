@extends('layouts.cms')

@section('title','Tambah Pesanan HomeClean')
@section('page-title','Tambah Pesanan HomeClean')

@section('content')

<div class="order-page-created">
  <div class="order-card">
    <div class="order-card-header">
      <div>
        <h3>Tambah Pesanan HomeClean</h3>
        <p>Input beberapa layanan home cleaning dalam satu form</p>
      </div>

      <a href="{{ route('admin.homecleaning.orders') }}" class="btn-modern btn-outline-modern">
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

    <form method="POST" action="{{ route('admin.homecleaning.orders.store') }}" class="order-form" id="homecleanOrderForm">
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

      <div id="homeclean-items">
        <div class="homeclean-item-card" data-subtotal="0" style="border:1px solid #eee; border-radius:14px; padding:16px; margin-bottom:16px;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <h4 style="margin:0;">Item 1</h4>
            <button type="button" class="btn-modern btn-outline-modern remove-item-btn" style="display:none;">Hapus</button>
          </div>

          <div class="form-grid">
            <div class="form-group">
              <label>Jenis Layanan</label>
              <select name="items[0][service_type]" class="homeclean-service" required>
                <option value="">Pilih Layanan</option>
                @foreach($services as $service)
                  <option value="{{ $service->id }}" data-price="{{ $service->price ?? 0 }}" data-unit="{{ $service->unit ?? '' }}" {{ old('items.0.service_type') == $service->id ? 'selected' : '' }}>
                    {{ $service->name }}@if($service->type) ({{ $service->type }})@endif
                    @if($service->price)
                      - Rp {{ number_format($service->price,0,',','.') }} / {{ $service->unit }}
                    @else
                      - Harga Manual
                    @endif
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group unit-group" style="display:none;">
              <label class="unit-label">Jumlah / Unit</label>
              <input type="number" name="items[0][unit_value]" class="homeclean-unit-value" min="0.01" step="0.01" placeholder="Masukkan jumlah" value="{{ old('items.0.unit_value') }}">
              <small class="unit-help"></small>
            </div>

            <div class="form-group manual-price-group" style="display:none;">
              <label>Harga Manual</label>
              <input type="number" name="items[0][manual_price]" class="homeclean-manual-price" min="0" step="1" placeholder="Masukkan total manual" value="{{ old('items.0.manual_price') }}">
            </div>

            <div class="form-group">
              <label>Subtotal</label>
              <input type="text" class="item-subtotal" readonly value="Rp 0">
            </div>
          </div>
        </div>
      </div>

      <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin:16px 0;">
        <button type="button" class="btn-modern btn-outline-modern" id="addHomecleanItemBtn">
          <i class="fa-solid fa-plus"></i>
          Tambah Item
        </button>

        <div style="font-weight:700; font-size:18px;">
          Total Semua: <span id="homecleanGrandTotal">Rp 0</span>
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

<template id="homeclean-item-template">
  <div class="homeclean-item-card" data-subtotal="0" style="border:1px solid #eee; border-radius:14px; padding:16px; margin-bottom:16px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
      <h4 style="margin:0;">Item __NUMBER__</h4>
      <button type="button" class="btn-modern btn-outline-modern remove-item-btn">Hapus</button>
    </div>

    <div class="form-grid">
      <div class="form-group">
        <label>Jenis Layanan</label>
        <select name="items[__INDEX__][service_type]" class="homeclean-service" required>
          <option value="">Pilih Layanan</option>
          @foreach($services as $service)
            <option value="{{ $service->id }}" data-price="{{ $service->price ?? 0 }}" data-unit="{{ $service->unit ?? '' }}">
              {{ $service->name }}@if($service->type) ({{ $service->type }})@endif
              @if($service->price)
                - Rp {{ number_format($service->price,0,',','.') }} / {{ $service->unit }}
              @else
                - Harga Manual
              @endif
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group unit-group" style="display:none;">
        <label class="unit-label">Jumlah / Unit</label>
        <input type="number" name="items[__INDEX__][unit_value]" class="homeclean-unit-value" min="0.01" step="0.01" placeholder="Masukkan jumlah">
        <small class="unit-help"></small>
      </div>

      <div class="form-group manual-price-group" style="display:none;">
        <label>Harga Manual</label>
        <input type="number" name="items[__INDEX__][manual_price]" class="homeclean-manual-price" min="0" step="1" placeholder="Masukkan total manual">
      </div>

      <div class="form-group">
        <label>Subtotal</label>
        <input type="text" class="item-subtotal" readonly value="Rp 0">
      </div>
    </div>
  </div>
</template>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('homeclean-items');
    const template = document.getElementById('homeclean-item-template').innerHTML;
    const addButton = document.getElementById('addHomecleanItemBtn');
    const grandTotalEl = document.getElementById('homecleanGrandTotal');

    function formatRupiah(value) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(value || 0));
    }

    function updateLabels() {
        container.querySelectorAll('.homeclean-item-card').forEach((card, index) => {
            card.querySelector('h4').textContent = 'Item ' + (index + 1);
            card.querySelector('.remove-item-btn').style.display = index === 0 ? 'none' : 'inline-flex';
        });
    }

    function updateGrandTotal() {
        let total = 0;
        container.querySelectorAll('.homeclean-item-card').forEach((card) => {
            total += Number(card.dataset.subtotal || 0);
        });
        grandTotalEl.textContent = formatRupiah(total);
    }

    function syncCard(card) {
        const service = card.querySelector('.homeclean-service');
        const unitGroup = card.querySelector('.unit-group');
        const manualGroup = card.querySelector('.manual-price-group');
        const unitInput = card.querySelector('.homeclean-unit-value');
        const manualInput = card.querySelector('.homeclean-manual-price');
        const unitLabel = card.querySelector('.unit-label');
        const unitHelp = card.querySelector('.unit-help');
        const subtotalInput = card.querySelector('.item-subtotal');

        const selected = service.options[service.selectedIndex];
        const price = Number(selected?.dataset.price || 0);
        const unit = selected?.dataset.unit || 'unit';

        if (price > 0) {
            unitGroup.style.display = 'block';
            manualGroup.style.display = 'none';
            unitInput.required = true;
            manualInput.required = false;
            manualInput.value = '';
            unitLabel.textContent = 'Jumlah / ' + unit;
            unitHelp.textContent = 'Harga satuan Rp ' + new Intl.NumberFormat('id-ID').format(price) + ' per ' + unit;
        } else if (service.value) {
            unitGroup.style.display = 'none';
            manualGroup.style.display = 'block';
            unitInput.required = false;
            manualInput.required = true;
            unitInput.value = '';
        } else {
            unitGroup.style.display = 'none';
            manualGroup.style.display = 'none';
            unitInput.required = false;
            manualInput.required = false;
            unitInput.value = '';
            manualInput.value = '';
        }

        let subtotal = 0;
        if (price > 0) subtotal = price * Number(unitInput.value || 0);
        if (price === 0) subtotal = Number(manualInput.value || 0);

        card.dataset.subtotal = subtotal;
        subtotalInput.value = formatRupiah(subtotal);
        updateGrandTotal();
    }

    function bindCard(card) {
        card.querySelector('.homeclean-service').addEventListener('change', function () { syncCard(card); });
        card.querySelector('.homeclean-unit-value').addEventListener('input', function () { syncCard(card); });
        card.querySelector('.homeclean-manual-price').addEventListener('input', function () { syncCard(card); });
        card.querySelector('.remove-item-btn').addEventListener('click', function () {
            card.remove();
            updateLabels();
            updateGrandTotal();
        });
        syncCard(card);
    }

    addButton.addEventListener('click', function () {
        const index = container.querySelectorAll('.homeclean-item-card').length;
        const html = template.replaceAll('__INDEX__', index).replaceAll('__NUMBER__', index + 1);
        container.insertAdjacentHTML('beforeend', html);
        bindCard(container.lastElementChild);
        updateLabels();
    });

    container.querySelectorAll('.homeclean-item-card').forEach(bindCard);
    updateLabels();
});
</script>
@endpush
