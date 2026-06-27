<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun owner default (untuk login pemilik kedai).
        // Customer tidak butuh akun, jadi tidak ada seeder untuk customer.
        $this->call([
            OwnerSeeder::class,
        ]);
    }
}