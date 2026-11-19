<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penyerahan;

class PenyerahanSeeder extends Seeder
{
    public function run(): void
    {
        Penyerahan::updateOrCreate(
            ['id_klaim' => 1],
            [
                'id_admin' => 1,
                'catatan' => 'Barang telah diserahkan kepada pemilik setelah verifikasi.',
            ]
        );
    }
}
