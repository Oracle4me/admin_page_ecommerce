<?php

namespace Database\Seeders;

use App\Modules\Auth\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun admin awal
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => 'admin123',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 🔹 Buat user contoh (opsional)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'user123',
            'role' => 'user',
        ]);
    }
}
