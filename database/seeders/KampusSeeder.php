<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kampus;

class KampusSeeder extends Seeder
{
    public function run(): void
    {
        Kampus::updateOrCreate(
            ['id_kampus' => 1],
            [
                'nama_kampus' => 'Universitas Gunadarma',
                'alamat' => 'Depok, Jawa Barat',
            ]
        );
    }
}
