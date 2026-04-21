<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class AddServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [

            // ================= LAUNDRY TAMBAHAN =================
            ['category'=>'Kebersihan','name'=>'Kayu','type'=>null,'unit'=>'m2','price'=>10000],
            ['category'=>'Kebersihan','name'=>'Lumut','type'=>null,'unit'=>'m2','price'=>35000],
            ['category'=>'Kebersihan','name'=>'Kanopy','type'=>null,'unit'=>'m2','price'=>4000],
            ['category'=>'Kebersihan','name'=>'Tiang Profil','type'=>null,'unit'=>'m2','price'=>5000],

            // ================= MOTOR & MOBIL =================
            ['category'=>'Motor','name'=>'Motor Besar','type'=>null,'unit'=>'unit','price'=>15000],
            ['category'=>'Motor','name'=>'Motor Kecil','type'=>null,'unit'=>'unit','price'=>20000],
            ['category'=>'Mobil','name'=>'Body','type'=>'Biasa','unit'=>'unit','price'=>20000],
            ['category'=>'Mobil','name'=>'Body','type'=>'Plak / Karat','unit'=>'unit','price'=>18000],
            ['category'=>'Mobil','name'=>'Detailing','type'=>'Tanpa Alat','unit'=>'unit','price'=>15000],
            ['category'=>'Mobil','name'=>'Detailing','type'=>'Pakai Alat','unit'=>'unit','price'=>40000],

            // ================= KEBERSIHAN RUMAH =================
            ['category'=>'Pembersihan Kamar Kos','name'=>'Pembersihan Kamar Kos','type'=>null,'unit'=>'jam','price'=>50000],
            ['category'=>'Jasa Kebersihan Rumah','name'=>'Jasa Kebersihan Rumah','type'=>null,'unit'=>'jam','price'=>65000],

            // ================= POLISH / REPAIR =================
            ['category'=>'Polish','name'=>'Polish','type'=>null,'unit'=>'unit','price'=>65000],
            ['category'=>'Repair Sine','name'=>'Repair Sine','type'=>'Biasa','unit'=>'unit','price'=>50000],
            ['category'=>'Repair Sine','name'=>'Repair Sine','type'=>'Plak','unit'=>'unit','price'=>50000],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
