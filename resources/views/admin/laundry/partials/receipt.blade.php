<div class="receipt-card">

  <div class="receipt-header">
    <h3>EAZY CLEANER CENTER</h3>
    <small>
      Jl. Soekarno Hatta, Garegeh<br>
      Kec. Mandiangin Koto Selayan<br>
      Kota Bukittinggi, Sumatera Barat 26117
    </small>
  </div>

  <div class="receipt-divider"></div>

  <div class="receipt-info">
    <p><strong>Invoice</strong><span>{{ $invoiceCode ?? $order->order_code }}</span></p>
    <p><strong>Tanggal</strong><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></p>
    <p><strong>Customer</strong><span>{{ $order->customer_name }}</span></p>
    <p><strong>WhatsApp</strong><span>{{ $order->customer_phone }}</span></p>
  </div>

  <div class="receipt-divider"></div>

  <div class="receipt-service">
    @foreach(($items ?? collect([$order])) as $item)
      <p>{{ $item->service->name }} ({{ ucfirst($item->type) }})</p>
      @if($item->type === 'kiloan')
        <p>{{ $item->weight }} kg x Rp {{ number_format($item->service->price,0,',','.') }}</p>
      @else
        <p>{{ $item->qty }} pcs x Rp {{ number_format($item->service->price,0,',','.') }}</p>
      @endif
      <p>Subtotal <span>Rp {{ number_format($item->total,0,',','.') }}</span></p>
      <p>Estimasi <span>{{ $item->service->duration }}</span></p>
      @if(!$loop->last)
        <div class="receipt-divider"></div>
      @endif
    @endforeach
  </div>

  <div class="receipt-divider"></div>

  <div class="receipt-total">
    <span>TOTAL</span>
    <span>Rp {{ number_format($invoiceTotal ?? $order->total,0,',','.') }}</span>
  </div>

  <div class="receipt-footer">
    Terima kasih telah mempercayakan<br>
    cucian Anda kepada <strong>Eazy Cleaner Center</strong> 🙏<br><br>
    Kami berkomitmen memberikan<br>
    hasil terbaik & pelayanan terbaik.<br>
    Silakan simpan struk ini sebagai<br>
    bukti pengambilan laundry.
  </div>

</div>
