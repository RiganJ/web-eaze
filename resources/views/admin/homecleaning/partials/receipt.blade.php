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
      <p><strong>Layanan:</strong></p>
      <p>{{ $item->service->name }}</p>
      @if($item->manual_price && $item->manual_price > 0)
          <p>Harga Manual</p>
          <p>Rp {{ number_format($item->manual_price,0,',','.') }}</p>
      @else
          <p>{{ rtrim(rtrim(number_format((float) $item->unit_value, 2, '.', ''), '0'), '.') }} {{ $item->service->unit ?? '' }} x Rp {{ number_format($item->service->price,0,',','.') }}</p>
      @endif
      <p>Subtotal <span>Rp {{ number_format($item->total,0,',','.') }}</span></p>
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
    Terima kasih telah menggunakan layanan<br>
    <strong>Eazy Cleaner Center - Home Cleaning</strong> 🙏<br><br>
    Kami berkomitmen memberikan<br>
    pelayanan kebersihan terbaik<br>
    untuk kenyamanan rumah Anda.<br>
    Simpan invoice ini sebagai<br>
    bukti transaksi.
  </div>

</div>
