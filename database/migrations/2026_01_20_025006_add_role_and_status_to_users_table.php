<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'super_admin',
                'owner',
                'admin_laundry',
                'admin_homeclean',
                'admin_detailing',
                'admin_carwash',
                'admin_cucianmotor',
                'admin_karsobed',
                'admin_polish',
            ])->after('email');

            $table->boolean('is_active')->default(true)->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_active']);
        });
    }
};
