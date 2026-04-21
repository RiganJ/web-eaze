<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // TOTAL INCOME 4 layanan
        $totalIncome =
            DB::table('laundry_orders')->where('status','selesai')->sum('total') +
            DB::table('homeclean_orders')->where('status','selesai')->sum('total') +
            DB::table('carwash_orders')->whereIn('status',['selesai','diambil'])->sum('price') +
            DB::table('cucian_motor_orders')->whereIn('status',['selesai','diambil'])->sum('price');

        // TOTAL ADMIN
        $totalAdmins = User::count();

        // TOTAL TRANSAKSI
        $totalOrders =
            DB::table('laundry_orders')->count() +
            DB::table('homeclean_orders')->count() +
            DB::table('carwash_orders')->count() +
            DB::table('cucian_motor_orders')->count();

        // PERTUMBUHAN BULANAN
        $currentMonthIncome =
            DB::table('laundry_orders')->whereMonth('order_date', $today->month)->where('status','selesai')->sum('total') +
            DB::table('homeclean_orders')->whereMonth('order_date', $today->month)->where('status','selesai')->sum('total') +
            DB::table('carwash_orders')->whereMonth('order_date', $today->month)->whereIn('status',['selesai','diambil'])->sum('price') +
            DB::table('cucian_motor_orders')->whereMonth('order_date', $today->month)->whereIn('status',['selesai','diambil'])->sum('price');

        $lastMonthIncome =
            DB::table('laundry_orders')->whereMonth('order_date', $today->copy()->subMonth()->month)->where('status','selesai')->sum('total') +
            DB::table('homeclean_orders')->whereMonth('order_date', $today->copy()->subMonth()->month)->where('status','selesai')->sum('total') +
            DB::table('carwash_orders')->whereMonth('order_date', $today->copy()->subMonth()->month)->whereIn('status',['selesai','diambil'])->sum('price') +
            DB::table('cucian_motor_orders')->whereMonth('order_date', $today->copy()->subMonth()->month)->whereIn('status',['selesai','diambil'])->sum('price');

        $monthlyGrowth = $lastMonthIncome > 0 ? round((($currentMonthIncome - $lastMonthIncome)/$lastMonthIncome)*100, 2) : 0;

        // SERVICE STATS
        $services = [
            'Laundry' => 'laundry_orders',
            'Home Cleaning' => 'homeclean_orders',
            'Car Wash' => 'carwash_orders',
            'Motor' => 'cucian_motor_orders'
        ];

        $serviceStats = [];
        foreach($services as $name => $table){
            $completed = DB::table($table)->whereIn('status',['selesai','diambil'])->count();
            $admin = DB::table('users')->where('role','admin')->first(); // contoh, bisa disesuaikan
            $serviceStats[$name] = [
                'completed' => $completed,
                'admin' => $admin->name ?? '-'
            ];
        }

        // ADMIN REPORT (pendapatan per admin)
        $adminReports = [];
        $admins = DB::table('users')->where('role','admin')->get();
        foreach($admins as $admin){
            $income = 0;
            foreach($services as $name => $table){
                $income += DB::table($table)->where('created_by',$admin->id)->sum('total');
            }
            $adminReports[$admin->name] = [
                'service' => 'Multiple',
                'income' => $income
            ];
        }

        // USERS
        $users = User::all();

        // CHART MINGGUAN
        $startWeek = $today->copy()->startOfWeek();
        $labels = [];
        $incomeData = [];

        for($i=0;$i<7;$i++){
            $date = $startWeek->copy()->addDays($i);
            $labels[] = $date->translatedFormat('D');
            $dayIncome =
                DB::table('laundry_orders')->whereDate('order_date',$date)->where('status','selesai')->sum('total') +
                DB::table('homeclean_orders')->whereDate('order_date',$date)->where('status','selesai')->sum('total') +
                DB::table('carwash_orders')->whereDate('order_date',$date)->whereIn('status',['selesai','diambil'])->sum('price') +
                DB::table('cucian_motor_orders')->whereDate('order_date',$date)->whereIn('status',['selesai','diambil'])->sum('price');
            $incomeData[] = $dayIncome;
        }

        return view('admin.dashboard.admin', compact(
            'totalIncome','totalAdmins','totalOrders','monthlyGrowth',
            'serviceStats','adminReports','users',
            'labels','incomeData'
        ));
    }
}

