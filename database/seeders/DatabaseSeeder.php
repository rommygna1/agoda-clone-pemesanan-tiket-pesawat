<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat 1 Akun Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@agoda.com',
            'password' => Hash::make('password123'), // Password default
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // Membuat 1 Akun User Biasa untuk testing
        User::create([
            'name' => 'User Test',
            'email' => 'user@agoda.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '089876543210',
        ]);
    }
}