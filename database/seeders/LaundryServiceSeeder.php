<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaundryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        DB::table('laundry_services')->insert([

            // 1. Cuci Gosok
            ['service_name'=>'Cuci Gosok','category'=>'Ekspress','price'=>12000,'unit'=>'kg','duration'=>'4 Jam','description'=>'Cuci >> Kering >> Setrika'],
            ['service_name'=>'Cuci Gosok','category'=>'Kilat','price'=>8000,'unit'=>'kg','duration'=>'1 Hari','description'=>'Cuci >> Kering >> Setrika'],
            ['service_name'=>'Cuci Gosok','category'=>'Reguler','price'=>6000,'unit'=>'kg','duration'=>'2 Hari','description'=>'Cuci >> Kering >> Setrika'],

            // 2. Cuci Only
            ['service_name'=>'Cuci Only','category'=>'Ekspress','price'=>9000,'unit'=>'kg','duration'=>'2 Jam','description'=>'Cuci >> Kering'],
            ['service_name'=>'Cuci Only','category'=>'Kilat','price'=>6000,'unit'=>'kg','duration'=>'1 Hari','description'=>'Cuci >> Kering'],
            ['service_name'=>'Cuci Only','category'=>'Reguler','price'=>4500,'unit'=>'kg','duration'=>'2 Hari','description'=>'Cuci >> Kering'],

            // 3. Setrika Only
            ['service_name'=>'Setrika Only','category'=>'Ekspress','price'=>9000,'unit'=>'kg','duration'=>'2 Jam','description'=>'Setrika'],
            ['service_name'=>'Setrika Only','category'=>'Kilat','price'=>6000,'unit'=>'kg','duration'=>'1 Hari','description'=>'Setrika'],
            ['service_name'=>'Setrika Only','category'=>'Reguler','price'=>4500,'unit'=>'kg','duration'=>'2 Hari','description'=>'Setrika'],

            // 4. Bed Cover
            ['service_name'=>'Bed Cover','category'=>'XL','price'=>40000,'unit'=>'pcs','duration'=>'6 Hari','description'=>'Cuci >> Kering'],
            ['service_name'=>'Bed Cover','category'=>'L','price'=>30000,'unit'=>'pcs','duration'=>'6 Hari','description'=>'Cuci >> Kering'],
            ['service_name'=>'Bed Cover','category'=>'M','price'=>25000,'unit'=>'pcs','duration'=>'6 Hari','description'=>'Cuci >> Kering'],
            ['service_name'=>'Bed Cover','category'=>'S','price'=>15000,'unit'=>'pcs','duration'=>'6 Hari','description'=>'Cuci >> Kering'],

            // 5. Bed Cover Set All
            ['service_name'=>'Bed Cover Set All','category'=>'XL','price'=>45000,'unit'=>'set','duration'=>'6 Hari','description'=>'Cuci >> Kering >> Setrika'],
            ['service_name'=>'Bed Cover Set All','category'=>'L','price'=>35000,'unit'=>'set','duration'=>'6 Hari','description'=>'Cuci >> Kering >> Setrika'],
            ['service_name'=>'Bed Cover Set All','category'=>'M','price'=>30000,'unit'=>'set','duration'=>'6 Hari','description'=>'Cuci >> Kering >> Setrika'],
            ['service_name'=>'Bed Cover Set All','category'=>'S','price'=>20000,'unit'=>'set','duration'=>'6 Hari','description'=>'Cuci >> Kering >> Setrika'],

            // 6. Selimut
            ['service_name'=>'Selimut','category'=>'XL','price'=>40000,'unit'=>'pcs','duration'=>'6 Hari','description'=>'Cuci >> Kering'],
            ['service_name'=>'Selimut','category'=>'L','price'=>30000,'unit'=>'pcs','duration'=>'6 Hari','description'=>'Cuci >> Kering'],
            ['service_name'=>'Selimut','category'=>'M','price'=>25000,'unit'=>'pcs','duration'=>'6 Hari','description'=>'Cuci >> Kering'],
            ['service_name'=>'Selimut','category'=>'S','price'=>15000,'unit'=>'pcs','duration'=>'6 Hari','description'=>'Cuci >> Kering'],

            // 7. Gorden
            ['service_name'=>'Gorden','category'=>'Reguler | Cuci Gosok','price'=>7000,'unit'=>'kg','duration'=>'7 Hari','description'=>'Cuci >> Kering >> Setrika'],
            ['service_name'=>'Gorden','category'=>'Reguler | Setrika Only','price'=>6000,'unit'=>'kg','duration'=>'7 Hari','description'=>'Setrika'],

            // 8. Bendera
            ['service_name'=>'Bendera','category'=>'Reguler | Cuci Gosok','price'=>7000,'unit'=>'kg','duration'=>'7 Hari','description'=>'Cuci >> Kering >> Setrika'],
            ['service_name'=>'Bendera','category'=>'Reguler | Setrika Only','price'=>6000,'unit'=>'kg','duration'=>'7 Hari','description'=>'Setrika'],

            // 9. Jas
            ['service_name'=>'Jas','category'=>'Ekspress','price'=>30000,'unit'=>'pcs','duration'=>'6 Jam','description'=>'Cuci >> Kering >> Setrika'],
            ['service_name'=>'Jas','category'=>'Kilat','price'=>25000,'unit'=>'pcs','duration'=>'1 Hari','description'=>'Cuci >> Kering >> Setrika'],
            ['service_name'=>'Jas','category'=>'Reguler','price'=>20000,'unit'=>'pcs','duration'=>'2 Hari','description'=>'Cuci >> Kering >> Setrika'],

            // 10. Boneka
            ['service_name'=>'Boneka','category'=>'Besar','price'=>30000,'unit'=>'pcs','duration'=>'3 Hari','description'=>'Cuci >> Kering'],
            ['service_name'=>'Boneka','category'=>'Sedang','price'=>20000,'unit'=>'pcs','duration'=>'3 Hari','description'=>'Cuci >> Kering'],
            ['service_name'=>'Boneka','category'=>'Kecil','price'=>10000,'unit'=>'pcs','duration'=>'3 Hari','description'=>'Cuci >> Kering'],

            // 11. Sepatu
            ['service_name'=>'Sepatu','category'=>'Reguler','price'=>10000,'unit'=>'psg','duration'=>'3 Hari','description'=>'Cuci >> Kering'],
        ]);
    }
}