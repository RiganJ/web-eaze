<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarwashOrder; // model untuk carwash
use App\Models\Service;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth; 
class CarwashAdminController extends Controller
{
    /**
     * Dashboard Admin Car Wash
     */
    public function dashboard()
{
    $today = Carbon::today();

    // =====================
    // CARD STATISTIC
    // =====================
    $totalToday = CarwashOrder::whereDate('order_date', $today)->count();

    $process = CarwashOrder::whereIn('status', ['pending', 'proses'])->count();

    $done = CarwashOrder::where('status', 'selesai')->count();

    $incomeToday = CarwashOrder::whereDate('order_date', $today)
                    ->whereIn('status', ['selesai', 'diambil'])
                    ->sum('price');

    // =====================
    // GRAFIK MINGGUAN
    // =====================
    $weeklyIncome = CarwashOrder::select(
            DB::raw('DATE(order_date) as date'),
            DB::raw('SUM(price) as total')
        )
        ->whereIn('status', ['selesai', 'diambil'])
        ->whereBetween('order_date', [
            $today->copy()->startOfWeek(),
            $today->copy()->endOfWeek()
        ])
        ->groupBy('date')
        ->pluck('total', 'date');

    $labels = [];
    $incomeData = [];

    // Ambil setiap hari dari awal minggu sampai akhir minggu
    for ($i = 0; $i < 7; $i++) {
        $date = $today->copy()->startOfWeek()->addDays($i);
        $labels[] = $date->translatedFormat('D');  // 'Sen', 'Sel', 'Rab', dst.
        $incomeData[] = $weeklyIncome[$date->toDateString()] ?? 0;
    }

    return view('admin.carwash.dashboard', compact(
        'totalToday',
        'process',
        'done',
        'incomeToday',
        'labels',
        'incomeData'
    ));
}
   /**
     * List Orders
     */
    public function orders()
    {
        return view('admin.carwash.orders', [
            'orders' => CarwashOrder::latest()->get()
        ]);
    }
    public function show($id)
    {
        $order = CarwashOrder::with('service')->findOrFail($id);

        return view('admin.carwash.detail', compact('order'));
    }
    /**
     * Update Status Order
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,batal'
        ]);

        CarwashOrder::findOrFail($id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diperbarui');
    }

    /**
     * Form Create Order
     */
    public function create()
    {
        // Ambil layanan Car Wash saja
        $services = Service::where('category', 'carwash')->get();

        return view('admin.carwash.create', compact('services'));
    }

    /**
     * Store Order Baru
     */
    public function store(Request $request)
{
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_phone' => 'required|string|max:20',
        'service_id' => 'required|exists:services,id',
    ]);

    $service = Service::findOrFail($request->service_id);

    // =========================
    // Generate Order Code CW-0001, CW-0002, dst
    // =========================
    $lastOrder = CarwashOrder::orderBy('id', 'desc')->first();
    if ($lastOrder) {
        // Ambil angka terakhir dari code sebelumnya
        $lastNumber = (int) str_replace('CW-', '', $lastOrder->order_code);
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1; // kalau belum ada order
    }

    // Format dengan leading zero, minimal 4 digit
    $orderCode = 'CW-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    // =========================
    // Simpan Order Baru
    // =========================
    CarwashOrder::create([
        'order_code'    => $orderCode,
        'customer_name' => $request->customer_name,
        'customer_phone' => $request->customer_phone,
        'service_id'    => $request->service_id,
        'vehicle_type'  => 'mobil',        // default
        'price'         => $service->price, // ambil harga dari service
        'status'        => 'pending',
        'order_date'    => now(),
        'created_by'    => Auth::id(),
    ]);

    return redirect()->route('carwash.orders')->with('success', 'Order berhasil dibuat dengan kode ' . $orderCode);
}
public function sendWa(CarwashOrder $order)
{
    $service = $order->service;

    $message = urlencode(
        "🚗 *EAZY CLEANER CENTER - CARWASH*\n" .
        "Jl. Soekarno Hatta, Garegeh\n" .
        "Kota Bukittinggi, Sumatera Barat\n\n" .

        "====================\n" .
        "*DETAIL CARWASH*\n" .
        "====================\n\n" .

        "Invoice   : {$order->order_code}\n" .
        "Tanggal   : {$order->created_at->format('d/m/Y H:i')}\n" .
        "Customer  : {$order->customer_name}\n" .
        "WhatsApp  : {$order->customer_phone}\n\n" .

        "Layanan   : {$service->name}\n" .
        "Kendaraan : {$order->vehicle_type}\n\n" .

        "TOTAL     : Rp " . number_format($order->price,0,',','.') . "\n\n" .

        "Terima kasih telah menggunakan\n" .
        "layanan *Eazy Cleaner Center* 🙏\n\n" .
        "Simpan pesan ini sebagai\n" .
        "bukti transaksi."
    );

    // Bersihkan nomor
    $phone = preg_replace('/[^0-9]/', '', $order->customer_phone);

    // Ubah 08xxxx jadi 628xxxx
    if (substr($phone, 0, 1) == '0') {
        $phone = '62' . substr($phone, 1);
    }

    return redirect("https://wa.me/{$phone}?text={$message}");
}

}
