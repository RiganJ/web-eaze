<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KarsobedOrder;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class KarsobedAdminController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();

        $totalToday = KarsobedOrder::whereDate('order_date', $today)->count();
        $process = KarsobedOrder::whereIn('status', ['pending','proses'])->count();
        $done = KarsobedOrder::where('status','selesai')->count();
        $incomeToday = KarsobedOrder::whereDate('order_date',$today)
                        ->whereIn('status',['selesai'])
                        ->sum('price');

        // Weekly income chart
        $weeklyIncome = KarsobedOrder::select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('SUM(price) as total')
            )
            ->whereIn('status', ['selesai'])
            ->whereBetween('order_date', [
                $today->copy()->startOfWeek(),
                $today->copy()->endOfWeek()
            ])
            ->groupBy('date')
            ->pluck('total','date');

        $labels = [];
        $incomeData = [];

        for($i=0;$i<7;$i++){
            $date = $today->copy()->startOfWeek()->addDays($i);
            $labels[] = $date->translatedFormat('D');
            $incomeData[] = $weeklyIncome[$date->toDateString()] ?? 0;
        }

        return view('admin.karsobed.dashboard', compact(
            'totalToday','process','done','incomeToday','labels','incomeData'
        ));
    }

    public function orders()
    {
        $orders = KarsobedOrder::with('service')->get();
        return view('admin.karsobed.orders', compact('orders'));
    }

public function create()
{
    // Ambil layanan KarSoBed dengan kategori tertentu
    $services = Service::whereIn('category', ['spring bed', 'sofa', 'kasur'])->get();

    return view('admin.karsobed.create', compact('services'));
}


    public function store(Request $request)
    {
        $service = Service::findOrFail($request->service_id);

        KarsobedOrder::create([
            'order_code' => 'ORD-' . strtoupper(Str::random(10)),
            'customer_name' => $request->customer_name,
            'service_id' => $service->id,
            'bed_type' => $request->bed_type,
            'price' => $service->price,
            'status' => 'pending',
            'order_date' => now(),
            'created_by' => Auth::id()
        ]);

        return redirect()->route('karsobed.orders')->with('success','Order berhasil ditambahkan');
    }

    public function updateStatus(Request $request, $id)
    {
        $order = KarsobedOrder::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success','Status berhasil diupdate');
    }
}
