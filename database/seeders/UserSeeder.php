<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'super_admin',
            'owner',
            'admin_laundry',
            'admin_homeclean',
            'admin_detailing',
            'admin_carwash',
            'admin_cucianmotor',
            'admin_karsobed',
            'admin_polish',
        ];

        foreach ($roles as $role) {
            User::create([
                'name' => strtoupper(str_replace('_', ' ', $role)),
                'email' => $role . '@app.test',
                'password' => Hash::make('password123'),
                'role' => $role,
                'is_active' => true,
            ]);
        }
    }
}
