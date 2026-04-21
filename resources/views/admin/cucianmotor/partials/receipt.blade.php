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
    <p><strong>Invoice</strong><span>{{ $order->order_code }}</span></p>
    <p><strong>Tanggal</strong><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></p>
    <p><strong>Customer</strong><span>{{ $order->customer_name }}</span></p>
    <p><strong>WhatsApp</strong><span>{{ $order->customer_phone }}</span></p>
    <p><strong>Kendaraan</strong><span>{{ ucfirst($order->vehicle_type) }}</span></p>
  </div>

  <div class="receipt-divider"></div>

  <div class="receipt-service">
    <p><strong>Layanan:</strong></p>
    <p>{{ $order->service->name }}</p>

    @if($order->manual_price && $order->manual_price > 0)
        <p>Harga Manual</p>
        <p>Rp {{ number_format($order->manual_price,0,',','.') }}</p>
    @else
        <p>Harga Paket</p>
        <p>Rp {{ number_format($order->service->price,0,',','.') }}</p>
    @endif
  </div>

  <div class="receipt-divider"></div>

  <div class="receipt-total">
    <span>TOTAL</span>
    <span>Rp {{ number_format($order->total,0,',','.') }}</span>
  </div>

  <div class="receipt-footer">
    Terima kasih telah menggunakan layanan<br>
    <strong>Eazy Cleaner Center - Carwash</strong> 🚗✨<br><br>
    Kendaraan bersih, nyaman, dan siap digunakan kembali.<br>
    Simpan invoice ini sebagai bukti transaksi.<br><br>
    Kepuasan Anda adalah prioritas kami.
  </div>

</div>