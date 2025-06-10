<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun admin tambahan (opsional)
        User::updateOrCreate(
            ['email' => 'admin@tel-klinik.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@tel-klinik.com',
                'password' => Hash::make('superadmin123'),
                'role' => 'admin',
                'user_type' => 'admin',
                'phone' => '08987654321',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}