<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satpam;
use Illuminate\Support\Facades\Hash;

class SatpamSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('demo.satpam_password');

        if (empty($password)) {
            return;
        }

        Satpam::firstOrCreate(
            ['email' => 'satpam.demo@gunadarma.ac.id'],
            [
                'id_kampus' => 1,
                'nama' => 'Satpam Demo',
                'password_hash' => Hash::make($password),
            ]
        );
    }
}
