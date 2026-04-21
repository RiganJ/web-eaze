<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminLayananController extends Controller
{
    public function index()
    {
        $serviceConfig = $this->serviceConfig();

        return view('admin.layanan.index', compact('serviceConfig'));
    }

    public function prices()
    {
        $services = Service::orderBy('category')
            ->orderBy('name')
            ->orderBy('type')
            ->get();

        $categories = Service::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin.layanan.prices', compact('services', 'categories'));
    }

    public function storePrice(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        Service::create($validated);

        return redirect()
            ->route('admin.layanan.prices')
            ->with('success', 'Harga layanan berhasil ditambahkan');
    }

    public function updatePrice(Request $request, Service $service)
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $service->update($validated);

        return redirect()
            ->route('admin.layanan.prices')
            ->with('success', 'Harga layanan berhasil diperbarui');
    }

    public function destroyPrice(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.layanan.prices')
            ->with('success', 'Harga layanan berhasil dihapus');
    }

    public function orders($category)
    {
        $serviceConfig = $this->serviceConfig();

        if (!isset($serviceConfig[$category])) {
            abort(404);
        }

        $table = $serviceConfig[$category]['table'];
        $totalColumn = $serviceConfig[$category]['total_column'];

        // Ambil semua order
        $orders = DB::table($table)
            ->select('*', DB::raw("$totalColumn as total_price"))
            ->latest()
            ->get();

        return view('admin.layanan.orders', [
            'orders'   => $orders,
            'category' => $category,
            'config'   => $serviceConfig[$category],
        ]);
    }

    private function serviceConfig()
    {
        return [
            'laundry' => [
                'label' => 'Laundry',
                'icon'  => 'fa-shirt',
                'class' => 'laundry',
                'table' => 'laundry_orders',
                'total_column' => 'total',
                'customer_column' => 'customer_name',
                'status_column' => 'status',
                'date_column' => 'order_date',
            ],
            'home_cleaning' => [
                'label' => 'Home Cleaning',
                'icon'  => 'fa-broom',
                'class' => 'homeclean',
                'table' => 'homeclean_orders',
                'total_column' => 'total',
                'customer_column' => 'customer_name',
                'status_column' => 'status',
                'date_column' => 'order_date',
            ],
            'car_wash' => [
                'label' => 'Car Wash',
                'icon'  => 'fa-car-side',
                'class' => 'carwash',
                'table' => 'carwash_orders',
                'total_column' => 'price',
                'customer_column' => 'customer_name',
                'status_column' => 'status',
                'date_column' => 'order_date',
            ],
            'motor_wash' => [
                'label' => 'Cucian Motor',
                'icon'  => 'fa-motorcycle',
                'class' => 'motorwash',
                'table' => 'cucian_motor_orders',
                'total_column' => 'total',
                'customer_column' => 'customer_name',
                'status_column' => 'status',
                'date_column' => 'order_date',
            ],
        ];
    }
}
