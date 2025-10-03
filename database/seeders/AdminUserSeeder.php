<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@lojavirtual.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'user_type' => 'admin',
                'status' => 'approved',
                'can_see_prices' => true,
                'approved_at' => now(),
                'email_verified_at' => now(),
            ]
        );
    }
}
