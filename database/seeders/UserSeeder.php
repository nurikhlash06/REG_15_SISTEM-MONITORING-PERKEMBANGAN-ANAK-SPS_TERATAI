<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed demo users (guru & orang tua).
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'nurikhlashazisanusi06@gmail.com'],
            [
                'name' => 'Nur Ikhlash',
                'password' => Hash::make('password'),
                'role' => 'orang_tua',
            ]
        );

        User::updateOrCreate(
            ['email' => 'guru@paud.com'],
            [
                'name' => 'Demo Guru',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]
        );

        User::updateOrCreate(
            ['email' => 'orangtua@paud.com'],
            [
                'name' => 'Demo Orang Tua',
                'password' => Hash::make('password'),
                'role' => 'orang_tua',
            ]
        );
    }
}

