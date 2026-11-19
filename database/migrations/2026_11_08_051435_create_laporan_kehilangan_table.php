<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kehilangan', function (Blueprint $table) {
            $table->increments('id_laporan');

            $table->unsignedInteger('id_kampus');
            $table->unsignedInteger('id_pelapor');

            $table->string('nama_barang', 150);
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_hilang');
            $table->string('lokasi_hilang', 180);
            $table->string('status', 40)->default('Diajukan');

            $table->foreign('id_kampus')
                ->references('id_kampus')
                ->on('kampus');

            $table->foreign('id_pelapor')
                ->references('id_pelapor')
                ->on('pelapor_kehilangan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kehilangan');
    }
};
