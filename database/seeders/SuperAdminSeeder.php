<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('demo.super_admin_password');

        if (empty($password)) {
            return;
        }

        SuperAdmin::firstOrCreate(
            ['email' => 'superadmin@gunadarma.ac.id'],
            [
                'nama' => 'Super Admin',
                'password_hash' => Hash::make($password),
            ]
        );
    }
}
