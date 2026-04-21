<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaundryOrder;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LaundryAdminController extends Controller
{
    private function extractInvoiceCode(?string $code): ?string
    {
        if (!$code) {
            return null;
        }

        if (preg_match('/^(LD-\d{6})/', $code, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function supportsBatchCode(): bool
    {
        return Schema::hasColumn('laundry_orders', 'batch_code');
    }

    private function generateBatchCode(): string
    {
        $maxNumber = 0;
        $codes = LaundryOrder::query()->select('order_code');

        if ($this->supportsBatchCode()) {
            $codes->addSelect('batch_code');
        }

        foreach ($codes->get() as $row) {
            $candidates = [$row->order_code];

            if ($this->supportsBatchCode()) {
                $candidates[] = $row->batch_code;
            }

            foreach ($candidates as $candidate) {
                $invoiceCode = $this->extractInvoiceCode($candidate);
                if ($invoiceCode) {
                    $maxNumber = max($maxNumber, (int) substr($invoiceCode, 3));
                }
            }
        }

        return 'LD-' . str_pad($maxNumber + 1, 6, '0', STR_PAD_LEFT);
    }

    private function getBatchItems(LaundryOrder $order)
    {
        $invoiceCode = $this->extractInvoiceCode($order->batch_code ?: $order->order_code) ?: $order->order_code;

        if (!$this->supportsBatchCode()) {
            return LaundryOrder::with('service')
                ->where('order_code', $invoiceCode)
                ->orderBy('id')
                ->get();
        }

        return LaundryOrder::with('service')
            ->when($order->batch_code, function ($query) use ($order) {
                $query->where('batch_code', $order->batch_code);
            }, function ($query) use ($invoiceCode) {
                $query->where('order_code', $invoiceCode);
            })
            ->orderBy('id')
            ->get();
    }

    public function dashboard()
    {
        $today = Carbon::today();

        $totalToday = LaundryOrder::whereDate('order_date', $today)->count();
        $process = LaundryOrder::whereIn('status', ['menunggu', 'proses'])->count();
        $done = LaundryOrder::where('status', 'selesai')->count();
        $incomeToday = LaundryOrder::whereDate('order_date', $today)
            ->whereIn('status', ['selesai', 'diambil'])
            ->sum('total');

        $weeklyIncome = LaundryOrder::select(
            DB::raw('DATE(order_date) as date'),
            DB::raw('SUM(total) as total')
        )
            ->whereIn('status', ['selesai', 'diambil'])
            ->whereBetween('order_date', [
                $today->copy()->startOfWeek(),
                $today->copy()->endOfWeek(),
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

        return view('admin.laundry.dashboard', compact(
            'totalToday',
            'process',
            'done',
            'incomeToday',
            'labels',
            'incomeData'
        ));
    }

    public function orders()
    {
        $orders = LaundryOrder::with('service')
            ->latest()
            ->get()
            ->groupBy(fn ($order) => ($this->supportsBatchCode() ? $order->batch_code : null) ?: ($this->extractInvoiceCode($order->order_code) ?: $order->order_code))
            ->map(function ($group) {
                $first = $group->sortBy('id')->first();

                return (object) [
                    'id' => $first->id,
                    'invoice_code' => $first->batch_code ?: $first->order_code,
                    'customer_name' => $first->customer_name,
                    'customer_phone' => $first->customer_phone,
                    'items_count' => $group->count(),
                    'items_summary' => $group->map(fn ($item) => $item->service->name . ' (' . ucfirst($item->type) . ')')->implode(', '),
                    'quantity_summary' => $group->map(function ($item) {
                        return $item->type === 'kiloan'
                            ? rtrim(rtrim(number_format((float) $item->weight, 2, '.', ''), '0'), '.') . ' kg'
                            : $item->qty . ' pcs';
                    })->implode(', '),
                    'total' => $group->sum('total'),
                    'status' => $first->status,
                    'order_date' => $first->order_date,
                ];
            })
            ->values();

        return view('admin.laundry.orders', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,diambil',
        ]);

        $order = LaundryOrder::findOrFail($id);
        $this->getBatchItems($order)->each->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status berhasil diperbarui');
    }

    public function create()
    {
        $services = Service::whereRaw('LOWER(category) = ?', ['laundry'])->get();

        return view('admin.laundry.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.type' => 'required|in:kiloan,satuan',
            'items.*.weight' => 'nullable|numeric|min:0.1',
            'items.*.qty' => 'nullable|integer|min:1',
        ]);

        foreach ($validated['items'] as $index => $item) {
            if ($item['type'] === 'kiloan' && empty($item['weight'])) {
                return back()->withErrors(["items.$index.weight" => 'Berat wajib diisi untuk item kiloan.'])->withInput();
            }

            if ($item['type'] === 'satuan' && empty($item['qty'])) {
                return back()->withErrors(["items.$index.qty" => 'Jumlah wajib diisi untuk item satuan.'])->withInput();
            }
        }

        DB::transaction(function () use ($validated) {
            $batchCode = $this->generateBatchCode();
            $nextItemNumber = 1;

            foreach ($validated['items'] as $item) {
                $service = Service::findOrFail($item['service_id']);

                if ($item['type'] === 'kiloan') {
                    $weight = (float) $item['weight'];
                    $qty = null;
                    $total = (int) round($service->price * $weight);
                } else {
                    $qty = (int) $item['qty'];
                    $weight = null;
                    $total = (int) round($service->price * $qty);
                }

                $data = [
                    'customer_name' => $validated['customer_name'],
                    'customer_phone' => $validated['customer_phone'],
                    'service_id' => $item['service_id'],
                    'type' => $item['type'],
                    'weight' => $weight,
                    'qty' => $qty,
                    'total' => $total,
                    'status' => 'menunggu',
                    'order_date' => now()->toDateString(),
                ];

                if ($this->supportsBatchCode()) {
                    $data['batch_code'] = $batchCode;
                    $data['order_code'] = $batchCode;
                } else {
                    $data['order_code'] = $batchCode;
                }

                LaundryOrder::create($data);

                $nextItemNumber++;
            }
        });

        return redirect()
            ->route('admin.laundry.orders')
            ->with('success', 'Pesanan laundry berhasil ditambahkan');
    }

    public function show($id)
    {
        $order = LaundryOrder::with('service')->findOrFail($id);
        $items = $this->getBatchItems($order);
        $invoiceCode = $order->batch_code ?: $order->order_code;
        $invoiceTotal = $items->sum('total');

        return view('admin.laundry.detail', compact('order', 'items', 'invoiceCode', 'invoiceTotal'));
    }

    public function sendWa(LaundryOrder $order)
    {
        $items = $this->getBatchItems($order);
        $invoiceCode = $order->batch_code ?: $order->order_code;
        $itemsText = $items->map(function ($item) {
            $qtyText = $item->type === 'kiloan' ? $item->weight . ' kg' : $item->qty . ' pcs';
            return "- {$item->service->name} (" . ucfirst($item->type) . ") - {$qtyText} - Rp " . number_format($item->total, 0, ',', '.');
        })->implode("\n");

        $message = urlencode(
            "ðŸ§º *EAZY CLEANER CENTER*\n" .
            "Jl. Soekarno Hatta, Garegeh\n" .
            "Kec. Mandiangin Koto Selayan\n" .
            "Kota Bukittinggi, Sumatera Barat 26117\n\n" .
            "====================\n" .
            "*DETAIL LAUNDRY*\n" .
            "====================\n\n" .
            "Invoice   : {$invoiceCode}\n" .
            "Tanggal   : {$order->created_at->format('d/m/Y H:i')}\n" .
            "Customer  : {$order->customer_name}\n" .
            "WhatsApp  : {$order->customer_phone}\n\n" .
            "Item Pesanan:\n{$itemsText}\n\n" .
            "TOTAL     : Rp " . number_format($items->sum('total'), 0, ',', '.') . "\n\n" .
            "Terima kasih telah mempercayakan\n" .
            "cucian Anda kepada *Eazy Cleaner Center* ðŸ™\n\n" .
            "Kami berkomitmen memberikan hasil\n" .
            "dan pelayanan terbaik untuk Anda.\n" .
            "Simpan pesan ini sebagai\n" .
            "bukti pengambilan laundry."
        );

        $phone = preg_replace('/[^0-9]/', '', $order->customer_phone);

        return redirect("https://wa.me/62{$phone}?text={$message}");
    }

    public function edit($id)
    {
        $order = LaundryOrder::with('service')->findOrFail($id);
        $services = Service::all();

        return view('admin.laundry.edit', compact('order', 'services'));
    }

    public function update(Request $request, $id)
    {
        $order = LaundryOrder::findOrFail($id);
        $order->update($request->all());

        return redirect()
            ->route('admin.laundry.orders.show', $order->id)
            ->with('success', 'Order berhasil diupdate');
    }
}
