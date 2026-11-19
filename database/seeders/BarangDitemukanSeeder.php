<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BarangDitemukan;

class BarangDitemukanSeeder extends Seeder
{
    public function run(): void
    {
        BarangDitemukan::updateOrCreate(
            ['id_barang' => 1],
            [
                'id_kampus' => 1,
                'sumber_penerimaan' => 'Satpam',
                'id_admin_validator' => null,
                'id_satpam' => 1,
                'id_admin_penerima' => null,
                'nama_publik' => 'Dompet Hitam',
                'kategori' => 'Aksesoris',
                'deskripsi_publik' => 'Dompet hitam ditemukan di area kampus.',
                'tanggal_ditemukan' => '2026-11-08',
                'lokasi_ditemukan' => 'Area Parkir Kampus',
                'status' => 'Diterima Satpam',
            ]
        );
    }
}
