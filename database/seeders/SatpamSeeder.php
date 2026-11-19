<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satpam;
use Illuminate\Support\Facades\Hash;

class SatpamSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('demo.account_password');

        if (empty($password)) {
            return;
        }

        Satpam::firstOrCreate(
            ['email' => 'satpam@gunadarma.ac.id'],
            [
                'id_kampus' => 1,
                'nama' => 'Satpam Gunadarma',
                'password_hash' => Hash::make($password),
            ]
        );
    }
}
