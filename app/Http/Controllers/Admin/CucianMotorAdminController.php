<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CucianMotorOrder;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

class CucianMotorAdminController extends Controller
{
    /**
     * Dashboard Cucian Motor
     */
    public function dashboard()
    {
        $today = Carbon::today();

        // =====================
        // CARD STATISTIC
        // =====================
        $totalToday = CucianMotorOrder::whereDate('order_date', $today)->count();

        $process = CucianMotorOrder::whereIn('status', ['pending', 'proses'])->count();

        $done = CucianMotorOrder::where('status', 'selesai')->count();

        $incomeToday = CucianMotorOrder::whereDate('order_date', $today)
                        ->where('status', 'selesai')
                        ->join('services', 'cucian_motor_orders.service_id', '=', 'services.id')
                        ->sum('services.price');

        // =====================
        // GRAFIK MINGGUAN
        // =====================
        $weeklyIncome = CucianMotorOrder::select(
                DB::raw('DATE(cucian_motor_orders.order_date) as date'),
                DB::raw('SUM(services.price) as total')
            )
            ->join('services', 'cucian_motor_orders.service_id', '=', 'services.id')
            ->where('status', 'selesai')
            ->whereBetween('order_date', [
                $today->copy()->startOfWeek(),
                $today->copy()->endOfWeek()
            ])
            ->groupBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $incomeData = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->startOfWeek()->addDays($i);
            $labels[] = $date->translatedFormat('D');
            $incomeData[] = $weeklyIncome[$date->toDateString()] ?? 0;
        }

        return view('admin.cucianmotor.dashboard', compact(
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
        $orders = CucianMotorOrder::with('service')->latest()->get();

        return view('admin.cucianmotor.orders', compact('orders'));
    }

    /**
     * Create Order Form
     */
    public function create()
    {
        $services = Service::where('category', 'motorwash')->get();

        return view('admin.cucianmotor.create', compact('services'));
    }

    /**
     * Store New Order
     */
    public function store(Request $request)
{
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'service_id'    => 'required|exists:services,id',
    ]);

    // =========================
    // GENERATE ORDER CODE CM-00001
    // =========================
    $lastOrder = CucianMotorOrder::orderBy('id', 'desc')->first();

    $nextNumber = $lastOrder
        ? intval(substr($lastOrder->order_code, 3)) + 1
        : 1;

    $orderCode = 'CM-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

    $now = now();

    CucianMotorOrder::create([
        'order_code'    => $orderCode,
        'customer_name' => $request->customer_name,
        'customer_phone' => $request->customer_phone,
        'service_id'    => $request->service_id,
        'vehicle_type'  => 'motor',
        'status'        => 'pending',
        'order_date'    => $now,
        'created_by'    => Auth::id(),
        'created_at'    => $now,
        'updated_at'    => $now,
    ]);

    return redirect()
        ->route('cucianmotor.orders')
        ->with('success', 'Order berhasil dibuat');
}

    /**
     * Update Status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,batal'
        ]);

        CucianMotorOrder::findOrFail($id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diperbarui');
    }
    public function show(CucianMotorOrder $order)
{
    $order->load('service');

    return view('admin.cucianmotor.detail', compact('order'));
}
public function sendWa(CucianMotorOrder $order)
{
    $order->load('service');
    $service = $order->service;

    $message = urlencode(
        "🏍️ *EAZY CLEANER CENTER - CUCIAN MOTOR*\n" .
        "Jl. Soekarno Hatta, Garegeh\n" .
        "Kota Bukittinggi, Sumatera Barat\n\n" .

        "====================\n" .
        "*DETAIL CUCIAN MOTOR*\n" .
        "====================\n\n" .

        "Invoice   : {$order->order_code}\n" .
        "Tanggal   : {$order->created_at->format('d/m/Y H:i')}\n" .
        "Customer  : {$order->customer_name}\n" .
        "WhatsApp  : {$order->customer_phone}\n\n" .

        "Layanan   : {$service->name}\n" .
        "Kendaraan : Motor\n\n" .

        "TOTAL     : Rp " . number_format($service->price,0,',','.') . "\n\n" .

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
