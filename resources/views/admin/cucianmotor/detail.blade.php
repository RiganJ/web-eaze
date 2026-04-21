@extends('layouts.cms')

@section('title','Detail Pesanan Carwash')

@section('sidebar')
@endsection

@section('content')

<div class="order-wrapper thermal-print-page" data-paper-width="80" id="thermalPrintPage">
  <div class="order-card">

    <!-- HEADER -->
    <div class="order-header">
      <div>
        <h4>Detail Pesanan</h4>
        <small>Invoice {{ $order->order_code }}</small>
      </div>

      <div class="action-cell">
<label class="paper-switch">
  Ukuran
  <select id="paperWidthSelect">
    <option value="58">58mm</option>
    <option value="80" selected>80mm</option>
  </select>
</label>
<a href="{{ route('cucianmotor.orders') }}" 
   class="btn-modern btn-outline-modern">
   <i class="fa-solid fa-arrow-left"></i>
   Kembali
</a>

        <a href="{{ route('cucianmotor.orders.sendWa', $order->id) }}"
           class="btn-gradient" target"_blank">
           📲 Kirim WhatsApp
        </a>

<button onclick="printReceipt()" 
        class="btn-modern btn-success-modern">
   <i class="fa-solid fa-print"></i>
   Cetak Struk
</button>
      </div>
    </div>

    <!-- BODY -->
    <div class="receipt-page">
      <div class="receipt-container">

        @include('admin.cucianmotor.partials.receipt')

      </div>
    </div>

  </div>
</div>

@endsection


@push('scripts')
<script>
const paperWidthSelect = document.getElementById('paperWidthSelect');
const thermalPrintPage = document.getElementById('thermalPrintPage');
const savedPaperWidth = localStorage.getItem('thermal-paper-width') || '80';

paperWidthSelect.value = savedPaperWidth;
thermalPrintPage.setAttribute('data-paper-width', savedPaperWidth);

paperWidthSelect.addEventListener('change', function () {
    thermalPrintPage.setAttribute('data-paper-width', this.value);
    localStorage.setItem('thermal-paper-width', this.value);
});

function printReceipt() {
    window.print();
}
</script>
@endpush


@push('styles')
<link rel="stylesheet" href="{{ asset('css/thermal-receipt.css') }}">
@endpush
