<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaporanKehilangan;

class LaporanKehilanganSeeder extends Seeder
{
    public function run(): void
    {
        LaporanKehilangan::updateOrCreate(
            ['id_laporan' => 1],
            [
                'id_kampus' => 1,
                'id_pelapor' => 1,
                'nama_barang' => 'Laptop ASUS',
                'deskripsi' => 'Laptop ASUS warna silver dengan stiker di bagian belakang.',
                'tanggal_hilang' => '2026-11-07',
                'lokasi_hilang' => 'Perpustakaan Kampus',
                'status' => 'Diajukan',
            ]
        );
    }
}
