<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiwayatAktivitas;

class RiwayatAktivitasSeeder extends Seeder
{
    public function run(): void
    {
        RiwayatAktivitas::updateOrCreate(
            [
                'id_aktivitas' => 1,
            ],
            [
                'id_super_admin' => null,
                'id_admin' => 1,
                'id_satpam' => null,
                'tindakan' => 'Memeriksa laporan barang temuan',
                'referensi_jenis' => 'barang_ditemukan',
                'referensi_id' => 1,
            ]
        );
    }
}
