<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void
    {
        Schema::create('laundry_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');     // Cuci Gosok, Bed Cover
            $table->string('category');         // Ekspress, Kilat, XL
            $table->integer('price');           // 12000
            $table->string('unit');             // kg, pcs, set, psg
            $table->string('duration');         // 4 Jam, 2 Hari
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry_services');
    }
};
