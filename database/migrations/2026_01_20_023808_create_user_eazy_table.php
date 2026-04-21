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
       Schema::create('user', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->enum('role', [
        'super_admin',
        'owner',
        'admin_laundry',
        'admin_homeclean',
        'admin_detailing',
        'admin_carwash',
        'admin_cucianmotor',
        'admin_karsobed',
        'admin_polish'

    ]);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
    $table->dropColumn('role');
});

    }
};
