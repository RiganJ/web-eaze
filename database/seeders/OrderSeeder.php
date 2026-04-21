<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all();

        if ($services->isEmpty()) {
            $this->command->warn('Service masih kosong');
            return;
        }

        foreach ($services as $service) {

            // 4–7 order per service
            for ($i = 1; $i <= rand(4, 7); $i++) {

                $orderDate = Carbon::now()->subDays(rand(0, 7));

                Order::create([
                    'service_id'    => $service->id,
                    'order_code'    => 'ORD-' . strtoupper(fake()->bothify('???###')),
                    'customer_name' => 'Customer ' . strtoupper(fake()->lexify('???')),
                    'phone'         => '08' . rand(1111111111, 9999999999),
                    'order_date'    => $orderDate,
                    'total_price'   => rand(1, 5) * $service->price,
                    'status'        => collect(['pending','process','done'])->random(),
                    'created_at'    => $orderDate,
                    'updated_at'    => now(),
                ]);
            }
        }
    }
}
