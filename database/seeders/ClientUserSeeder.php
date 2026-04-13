<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'joao.silva@email.com.br'],
            [
                'name' => 'João Silva',
                'password' => Hash::make('cliente123'),
                'user_type' => 'customer',
                'status' => 'approved',
                'can_see_prices' => true,
                'approved_at' => now(),
                'email_verified_at' => now(),
            ]
        );
    }
}
