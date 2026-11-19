<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminKampus;
use Illuminate\Support\Facades\Hash;

class AdminKampusSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('demo.account_password');

        if (empty($password)) {
            return;
        }

        AdminKampus::firstOrCreate(
            ['email' => 'admin@gunadarma.ac.id'],
            [
                'id_kampus' => 1,
                'id_super_admin_pembuat' => 1,
                'nama' => 'Admin Kampus',
                'password_hash' => Hash::make($password),
            ]
        );
    }
}
