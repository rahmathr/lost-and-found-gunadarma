<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_ditemukan', function (Blueprint $table) {
            $table->increments('id_barang');

            $table->unsignedInteger('id_kampus');
            $table->string('sumber_penerimaan', 20);

            $table->unsignedInteger('id_admin_validator')->nullable();
            $table->unsignedInteger('id_satpam')->nullable();
            $table->unsignedInteger('id_admin_penerima')->nullable();

            $table->string('nama_publik', 150);
            $table->string('kategori', 80);
            $table->text('deskripsi_publik')->nullable();
            $table->date('tanggal_ditemukan');
            $table->string('lokasi_ditemukan', 180);
            $table->string('status', 40);

            $table->foreign('id_kampus')
                ->references('id_kampus')
                ->on('kampus');

            $table->foreign('id_admin_validator')
                ->references('id_admin')
                ->on('admin_kampus');

            $table->foreign('id_satpam')
                ->references('id_satpam')
                ->on('satpam');

            $table->foreign('id_admin_penerima')
                ->references('id_admin')
                ->on('admin_kampus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_ditemukan');
    }
};
