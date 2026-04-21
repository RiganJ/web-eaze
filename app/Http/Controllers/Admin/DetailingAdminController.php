<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailingOrder; // pastikan ada model untuk detailing
use App\Models\Service;
use Carbon\Carbon;
use DB;
class DetailingAdminController extends Controller
{
    /**
     * Dashboard Admin Detailing
     */
    public function dashboard()
    {
        $today = now()->toDateString();

        return view('admin.detailing.dashboard', [
            'totalToday' => DetailingOrder::whereDate('order_date', $today)->count(),
            'process' => DetailingOrder::whereIn('status', ['menunggu', 'proses'])->count(),
            'done' => DetailingOrder::where('status', 'selesai')->count(),
            'incomeToday' => DetailingOrder::whereDate('order_date', $today)
                                ->whereIn('status', ['selesai', 'diambil'])
                                ->sum('total'),
        ]);
    }

    /**
     * List Orders
     */
    public function orders()
    {
        return view('admin.detailing.orders', [
            'orders' => DetailingOrder::latest()->get()
        ]);
    }

    /**
     * Update Status Order
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,diambil'
        ]);

        DetailingOrder::findOrFail($id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diperbarui');
    }
    public function create()
{
    // Jika Anda memiliki model Kategori atau data lain yang terkait
    // pastikan Anda hanya mengambil kategori "detailing"
    $services = Service::where('category', 'detailing')->get(); 

    return view('admin.detailing.create', compact('services'));
}

public function store(Request $request)
{
    // Validasi data yang diterima dari form
    $request->validate([
        'service_id' => 'required|exists:services,id', // Validasi ID layanan
        'customer_name' => 'required|string|max:255',
        'weight' => 'required|numeric|min:0.1', // Validasi berat cucian
        'type' => 'required|in:kiloan,satuan', // Validasi jenis laundry
    ]);

    // Generate order_code (misalnya menggunakan uniqid() atau random string)
    $order_code = 'ORD-' . strtoupper(uniqid());

    // Generate order_date otomatis
    $order_date = now();

    // Simpan order laundry baru ke database
    DetailingOrder::create([
        'order_code' => $order_code,  // Kode order otomatis
        'service_id' => $request->service_id,
        'customer_name' => $request->customer_name,
        'type' => $request->type,
        'vehicle_type' => $request->vehicle_type ?? 'default',  // Default jika tidak ada input
        'total' => $request->total ?? 0,  // Pastikan total dihitung atau default 0
        'status' => 'menunggu',  // Status default
        'order_date' => $order_date, // Tanggal otomatis
        'created_at' => $order_date,
        'updated_at' => $order_date,
    ]);

    return redirect()->route('detailing.orders')->with('success', 'Order berhasil dibuat');
}


}
