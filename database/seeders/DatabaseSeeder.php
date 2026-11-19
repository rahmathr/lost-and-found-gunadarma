<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data awal aplikasi: kampus dan akun petugas saja.
        // Tidak membuat akun Pelapor maupun data transaksi contoh.
        $this->call([
            KampusSeeder::class,
            SuperAdminSeeder::class,
            AdminKampusSeeder::class,
            SatpamSeeder::class,
        ]);
    }
}
