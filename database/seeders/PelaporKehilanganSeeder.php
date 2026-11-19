<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PelaporKehilangan;
use Illuminate\Support\Facades\Hash;

class PelaporKehilanganSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('demo.account_password');

        if (empty($password)) {
            return;
        }

        PelaporKehilangan::firstOrCreate(
            ['email' => 'pelapor@example.com'],
            [
                'nama' => 'Pelapor Demo',
                'password_hash' => Hash::make($password),
            ]
        );
    }
}
