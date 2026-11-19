<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Status lama penerimaan Satpam dipetakan berdasarkan sumbernya.
        DB::table('barang_ditemukan')
            ->where('status', 'Menunggu Validasi')
            ->where('sumber_penerimaan', 'Satpam')
            ->update(['status' => 'Diterima Satpam']);

        // Penerimaan langsung oleh Admin pada versi lama sudah masuk tahap pemeriksaan.
        // Status Dalam Pemeriksaan tidak diubah.

        DB::table('barang_ditemukan')
            ->where('status', 'Tervalidasi')
            ->update(['status' => 'Dipublikasikan']);

        DB::table('klaim')
            ->where('status', 'Memerlukan Bukti Tambahan')
            ->update(['status' => 'Perlu Bukti Tambahan']);
    }

    public function down(): void
    {
        DB::table('barang_ditemukan')
            ->where('status', 'Diterima Satpam')
            ->where('sumber_penerimaan', 'Satpam')
            ->update(['status' => 'Menunggu Validasi']);

        DB::table('barang_ditemukan')
            ->where('status', 'Dipublikasikan')
            ->update(['status' => 'Tervalidasi']);

        DB::table('klaim')
            ->where('status', 'Perlu Bukti Tambahan')
            ->update(['status' => 'Memerlukan Bukti Tambahan']);
    }
};
