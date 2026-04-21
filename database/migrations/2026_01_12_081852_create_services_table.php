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
    Schema::create('services', function (Blueprint $table) {
        $table->id();
        $table->string('category');      // Laundry, Karpet, Kasur, dll
        $table->string('name');          // Nama layanan
        $table->string('type')->nullable(); // Jenis / size
        $table->string('unit')->nullable(); // kg, m2, unit
        $table->integer('price');        // harga numerik
        $table->string('note')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
