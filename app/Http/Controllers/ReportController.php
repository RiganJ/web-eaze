<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;

        // CONVERT KE CARBON UNTUK AMAN
        $startDate = $start ? Carbon::parse($start)->startOfDay() : null;
        $endDate   = $end ? Carbon::parse($end)->endOfDay() : null;

        $orders = collect();

        // 1. Laundry Orders
        $query = DB::table('laundry_orders')->select(
            'order_code',
            'order_date',
            DB::raw('total as total_price')
        )->where('status', 'selesai');

        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }
        $orders = $orders->merge($query->get());

        // 2. Home Cleaning Orders
        $query = DB::table('homeclean_orders')->select(
            'order_code',
            'order_date',
            DB::raw('total as total_price')
        )->where('status', 'selesai');

        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }
        $orders = $orders->merge($query->get());

        // 3. Car Wash Orders
        $query = DB::table('carwash_orders')->select(
            'order_code',
            'order_date',
            DB::raw('price as total_price')
        )->whereIn('status', ['selesai','diambil']);

        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }
        $orders = $orders->merge($query->get());

        // 4. Cucian Motor Orders
        $query = DB::table('cucian_motor_orders')->select(
            'order_code',
            'order_date',
            DB::raw('total as total_price')
        )->whereIn('status', ['selesai','diambil']);

        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }
        $orders = $orders->merge($query->get());

        // SORTING TERBARU
        $orders = $orders->sortByDesc('order_date')->values();

        // TOTAL INCOME & TOTAL ORDER
        $totalIncome = $orders->sum('total_price');
        $totalOrder  = $orders->count();

        return view('admin.report.finance', compact(
            'orders',
            'totalIncome',
            'totalOrder',
            'start',
            'end'
        ));
    }
}
