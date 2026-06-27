<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Buat 1 akun owner default kalau belum ada.
     * Silakan login lalu ganti passwordnya kalau perlu.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'owner@cafehanz.com'],
            [
                'name' => 'Owner Cafe Hanz',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
            ]
        );
    }
}
