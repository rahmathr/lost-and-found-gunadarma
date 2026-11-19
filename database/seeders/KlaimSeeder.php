<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaim;

class KlaimSeeder extends Seeder
{
    public function run(): void
    {
        Klaim::updateOrCreate(
            ['id_klaim' => 1],
            [
                'id_barang' => 1,
                'id_pelapor' => 1,
                'id_admin' => null,
                'keterangan_privat' => 'Saya dapat menyebutkan ciri khusus barang dan isi dompet tersebut.',
                'status' => 'Menunggu Verifikasi',
                'catatan_admin' => null,
            ]
        );
    }
}
