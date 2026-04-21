<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [

            // ================= LAUNDRY =================
            ['category'=>'Laundry','name'=>'Cuci Gosok','type'=>null,'unit'=>'kg','price'=>7000],
            ['category'=>'Laundry','name'=>'Setrika Only','type'=>null,'unit'=>'kg','price'=>4500],
            ['category'=>'Laundry','name'=>'Cuci Only','type'=>null,'unit'=>'kg','price'=>4500],

            // Selimut
            ['category'=>'Laundry','name'=>'Selimut','type'=>'XS','unit'=>'unit','price'=>10000],
            ['category'=>'Laundry','name'=>'Selimut','type'=>'S','unit'=>'unit','price'=>15000],
            ['category'=>'Laundry','name'=>'Selimut','type'=>'M','unit'=>'unit','price'=>25000],
            ['category'=>'Laundry','name'=>'Selimut','type'=>'L','unit'=>'unit','price'=>30000],
            ['category'=>'Laundry','name'=>'Selimut','type'=>'XL','unit'=>'unit','price'=>40000],
            ['category'=>'Laundry','name'=>'Selimut','type'=>'XXL','unit'=>'unit','price'=>45000],

            // ================= KARPET =================
            ['category'=>'Karpet','name'=>'Karpet','type'=>'Biasa','unit'=>'meter','price'=>8000],
            ['category'=>'Karpet','name'=>'Karpet','type'=>'Sunblast','unit'=>'meter','price'=>6000],
            ['category'=>'Karpet','name'=>'Karpet','type'=>'72 Meter','unit'=>'meter','price'=>10000],

            // ================= KASUR =================
            ['category'=>'Kasur','name'=>'Kasur Palembang','type'=>'M','unit'=>'unit','price'=>35000],
            ['category'=>'Kasur','name'=>'Kasur Palembang','type'=>'L','unit'=>'unit','price'=>50000],
            ['category'=>'Kasur','name'=>'Kasur Palembang','type'=>'XL','unit'=>'unit','price'=>80000],

            // ================= SPRING BED =================
            ['category'=>'Spring Bed','name'=>'Single Size','type'=>'Single','unit'=>'unit','price'=>120000],
            ['category'=>'Spring Bed','name'=>'Double Size','type'=>'Double','unit'=>'unit','price'=>200000],
            ['category'=>'Spring Bed','name'=>'Queen Size','type'=>'Queen','unit'=>'unit','price'=>250000],
            ['category'=>'Spring Bed','name'=>'King Size','type'=>'King','unit'=>'unit','price'=>300000],
            ['category'=>'Spring Bed','name'=>'Super King Size','type'=>'Super King','unit'=>'unit','price'=>350000],

            // ================= SOFA =================
            ['category'=>'Sofa','name'=>'Sofa','type'=>'Kulit','unit'=>'per dudukan','price'=>30000],
            ['category'=>'Sofa','name'=>'Sofa','type'=>'Kain','unit'=>'per dudukan','price'=>50000],

            // ================= VACUM =================
            ['category'=>'Vacuming','name'=>'Vacuming','type'=>'All Type','unit'=>'meter','price'=>20000],
            ['category'=>'Vacuming','name'=>'Vacuming','type'=>'Vacum Tungau','unit'=>'meter','price'=>20000],

            // ================= KACA =================
            ['category'=>'Kaca','name'=>'Kaca','type'=>'Biasa','unit'=>'meter','price'=>5000],
            ['category'=>'Kaca','name'=>'Kaca','type'=>'Sunblast','unit'=>'meter','price'=>8000],

            // ================= LANTAI =================
            ['category'=>'Lantai','name'=>'Biasa','type'=>null,'unit'=>'m2','price'=>35000],
            ['category'=>'Lantai','name'=>'Granit','type'=>null,'unit'=>'m2','price'=>45000],
            ['category'=>'Lantai','name'=>'Marmer','type'=>null,'unit'=>'m2','price'=>50000],

            // Kristalisasi
            ['category'=>'Kristalisasi Lantai','name'=>'Marmer','type'=>null,'unit'=>'m2','price'=>75000],
            ['category'=>'Kristalisasi Lantai','name'=>'Terasso','type'=>null,'unit'=>'m2','price'=>65000],
            ['category'=>'Kristalisasi Lantai','name'=>'Granit','type'=>null,'unit'=>'m2','price'=>110000],

            // Lantai Kamar Mandi
            ['category'=>'Lantai Kamar Mandi','name'=>'Biasa','type'=>null,'unit'=>'m2','price'=>40000],
            ['category'=>'Lantai Kamar Mandi','name'=>'Plak','type'=>null,'unit'=>'m2','price'=>60000],

            // ================= AQUARIUM =================
            ['category'=>'Aquarium','name'=>'Aquarium','type'=>'Small','unit'=>'unit','price'=>35000],
            ['category'=>'Aquarium','name'=>'Aquarium','type'=>'Medium','unit'=>'unit','price'=>60000],
            ['category'=>'Aquarium','name'=>'Aquarium','type'=>'Large','unit'=>'unit','price'=>100000],
            ['category'=>'Aquarium','name'=>'Aquarium','type'=>'XL','unit'=>'unit','price'=>150000],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
