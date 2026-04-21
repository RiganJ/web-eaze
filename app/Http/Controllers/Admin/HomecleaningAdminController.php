<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomecleanOrder;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomecleaningAdminController extends Controller
{
    private function extractInvoiceCode(?string $code): ?string
    {
        if (!$code) {
            return null;
        }

        if (preg_match('/^(HC-\d{6})/', $code, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function supportsBatchCode(): bool
    {
        return Schema::hasColumn('homeclean_orders', 'batch_code');
    }

    private function generateBatchCode(): string
    {
        $maxNumber = 0;
        $codes = HomecleanOrder::query()->select('order_code');

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

        return 'HC-' . str_pad($maxNumber + 1, 6, '0', STR_PAD_LEFT);
    }

    private function getBatchItems(HomecleanOrder $order)
    {
        $invoiceCode = $this->extractInvoiceCode($order->batch_code ?: $order->order_code) ?: $order->order_code;

        if (!$this->supportsBatchCode()) {
            return HomecleanOrder::with('service')
                ->where('order_code', $invoiceCode)
                ->orderBy('id')
                ->get();
        }

        return HomecleanOrder::with('service')
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

        $totalToday = HomecleanOrder::whereDate('order_date', $today)->count();
        $process = HomecleanOrder::whereIn('status', ['menunggu', 'proses'])->count();
        $done = HomecleanOrder::where('status', 'selesai')->count();
        $incomeToday = HomecleanOrder::whereDate('order_date', $today)
            ->whereIn('status', ['selesai', 'diambil'])
            ->sum('total');

        $weeklyIncome = HomecleanOrder::select(
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

        return view('admin.homecleaning.dashboard', compact(
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
        $orders = HomecleanOrder::with('service')
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
                    'items_summary' => $group->map(fn ($item) => $item->service->name)->implode(', '),
                    'quantity_summary' => $group->map(function ($item) {
                        if (!empty($item->unit_value)) {
                            return rtrim(rtrim(number_format((float) $item->unit_value, 2, '.', ''), '0'), '.') . ' ' . ($item->service->unit ?? '');
                        }

                        return 'Manual';
                    })->implode(', '),
                    'total' => $group->sum('total'),
                    'status' => $first->status,
                    'order_date' => $first->order_date,
                ];
            })
            ->values();

        return view('admin.homecleaning.orders', compact('orders'));
    }

    public function create()
    {
        $services = Service::where('category', 'CLEANING')->get();

        return view('admin.homecleaning.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.service_type' => 'required|exists:services,id',
            'items.*.unit_value' => 'nullable|numeric|min:0.01',
            'items.*.manual_price' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated['items'] as $index => $item) {
            $service = Service::findOrFail($item['service_type']);

            if (!empty($service->price) && empty($item['unit_value'])) {
                return back()->withErrors(["items.$index.unit_value" => 'Jumlah/unit wajib diisi untuk layanan ini.'])->withInput();
            }

            if ((empty($service->price) || $service->price == 0) && !isset($item['manual_price'])) {
                return back()->withErrors(["items.$index.manual_price" => 'Harga manual wajib diisi untuk layanan tanpa harga default.'])->withInput();
            }
        }

        DB::transaction(function () use ($validated) {
            $batchCode = $this->generateBatchCode();
            $nextItemNumber = 1;

            foreach ($validated['items'] as $item) {
                $service = Service::findOrFail($item['service_type']);

                if (empty($service->price) || $service->price == 0) {
                    $unitValue = null;
                    $manualPrice = (int) round($item['manual_price']);
                    $total = $manualPrice;
                } else {
                    $unitValue = (float) $item['unit_value'];
                    $manualPrice = null;
                    $total = (int) round($service->price * $unitValue);
                }

                $data = [
                    'customer_name' => $validated['customer_name'],
                    'customer_phone' => $validated['customer_phone'],
                    'service_type' => $service->id,
                    'unit_value' => $unitValue,
                    'manual_price' => $manualPrice,
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

                HomecleanOrder::create($data);

                $nextItemNumber++;
            }
        });

        return redirect()
            ->route('admin.homecleaning.orders')
            ->with('success', 'Pesanan HomeClean berhasil ditambahkan');
    }

    public function show($id)
    {
        $order = HomecleanOrder::with('service')->findOrFail($id);
        $items = $this->getBatchItems($order);
        $invoiceCode = $order->batch_code ?: $order->order_code;
        $invoiceTotal = $items->sum('total');

        return view('admin.homecleaning.detail', compact('order', 'items', 'invoiceCode', 'invoiceTotal'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,diambil',
        ]);

        $order = HomecleanOrder::findOrFail($id);
        $this->getBatchItems($order)->each->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status berhasil diperbarui');
    }

    public function sendWa(HomecleanOrder $order)
    {
        $items = $this->getBatchItems($order);
        $invoiceCode = $order->batch_code ?: $order->order_code;
        $itemsText = $items->map(function ($item) {
            $qtyText = !empty($item->unit_value)
                ? rtrim(rtrim(number_format((float) $item->unit_value, 2, '.', ''), '0'), '.') . ' ' . ($item->service->unit ?? '')
                : 'Manual';

            return "- {$item->service->name} - {$qtyText} - Rp " . number_format($item->total, 0, ',', '.');
        })->implode("\n");

        $message = urlencode(
            "ðŸ§¹ *EAZY CLEANER CENTER - HOMECLEAN*\n" .
            "Jl. Soekarno Hatta, Garegeh\n" .
            "Kec. Mandiangin Koto Selayan\n" .
            "Kota Bukittinggi, Sumatera Barat 26117\n\n" .
            "====================\n" .
            "*DETAIL HOMECLEAN*\n" .
            "====================\n\n" .
            "Invoice   : {$invoiceCode}\n" .
            "Tanggal   : {$order->created_at->format('d/m/Y H:i')}\n" .
            "Customer  : {$order->customer_name}\n" .
            "WhatsApp  : {$order->customer_phone}\n\n" .
            "Item Pesanan:\n{$itemsText}\n\n" .
            "TOTAL     : Rp " . number_format($items->sum('total'), 0, ',', '.') . "\n\n" .
            "Terima kasih telah menggunakan\n" .
            "layanan *Eazy Cleaner Center* ðŸ™\n\n" .
            "Kami berkomitmen memberikan\n" .
            "pelayanan kebersihan terbaik\n" .
            "untuk kenyamanan rumah Anda.\n\n" .
            "Simpan pesan ini sebagai\n" .
            "bukti transaksi."
        );

        $phone = preg_replace('/[^0-9]/', '', $order->customer_phone);

        return redirect("https://wa.me/{$phone}?text={$message}");
    }

    public function edit($id)
    {
        $order = HomecleanOrder::with('service')->findOrFail($id);
        $services = Service::where('category', 'CLEANING')->get();

        return view('admin.homecleaning.edit', compact('order', 'services'));
    }

    public function update(Request $request, $id)
    {
        $order = HomecleanOrder::findOrFail($id);
        $order->update($request->all());

        return redirect()
            ->route('admin.homecleaning.orders.show', $order->id)
            ->with('success', 'Order berhasil diupdate');
    }
}
