<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PolishOrder;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class PolishAdminController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();

        $totalToday = PolishOrder::whereDate('order_date', $today)->count();
        $process = PolishOrder::whereIn('status', ['pending','proses'])->count();
        $done = PolishOrder::where('status','selesai')->count();
        $incomeToday = PolishOrder::whereDate('order_date',$today)
                        ->whereIn('status',['selesai'])
                        ->sum('price');

        // Weekly income chart
        $weeklyIncome = PolishOrder::select(
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

        return view('admin.polish.dashboard', compact(
            'totalToday','process','done','incomeToday','labels','incomeData'
        ));
    }

    public function orders()
    {
        $orders = PolishOrder::with('service')->get();
        return view('admin.polish.orders', compact('orders'));
    }

    public function create()
    {
        $services = Service::where('category','polish')->get();
        return view('admin.polish.create', compact('services'));
    }

    public function store(Request $request)
    {
        $service = Service::findOrFail($request->service_id);

        PolishOrder::create([
            'order_code' => 'ORD-' . strtoupper(Str::random(10)),
            'customer_name' => $request->customer_name,
            'service_id' => $service->id,
            'vehicle_type' => $request->vehicle_type,
            'price' => $service->price,
            'status' => 'pending',
            'order_date' => now(),
            'created_by' => Auth::id()
        ]);

        return redirect()->route('polish.orders.index')->with('success','Order berhasil ditambahkan');
    }

    public function updateStatus(Request $request, $id)
    {
        $order = PolishOrder::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success','Status berhasil diupdate');
    }
}
