<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laundry_orders', function (Blueprint $table) {
            $table->dropUnique('laundry_orders_order_code_unique');
        });
    }

    public function down(): void
    {
        Schema::table('laundry_orders', function (Blueprint $table) {
            $table->unique('order_code');
        });
    }
};
