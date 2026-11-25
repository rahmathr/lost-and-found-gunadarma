<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminKampus;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Hash;

class AdminKampusSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('demo.admin_password');

        if (empty($password)) {
            return;
        }

        $superAdmin = SuperAdmin::where(
            'email',
            'superadmin@gunadarma.ac.id'
        )->first();

        if (!$superAdmin) {
            return;
        }

        AdminKampus::firstOrCreate(
            ['email' => 'admin.demo@gunadarma.ac.id'],
            [
                'id_kampus' => 1,
                'id_super_admin_pembuat' => $superAdmin->id_super_admin,
                'nama' => 'Admin Demo',
                'password_hash' => Hash::make($password),
            ]
        );
    }
}
