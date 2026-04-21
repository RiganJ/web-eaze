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
Schema::create('laundry_orders', function (Blueprint $table) {
    $table->id();
    $table->string('order_code')->unique();
    $table->string('customer_name');
    $table->enum('type',['kiloan','satuan']);
    $table->decimal('weight',5,2)->nullable();
    $table->integer('total');
    $table->enum('status',['menunggu','proses','selesai','diambil'])->default('menunggu');
    $table->date('order_date');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry_orders');
    }
};
