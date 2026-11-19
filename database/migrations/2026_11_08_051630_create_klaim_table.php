
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klaim', function (Blueprint $table) {
            $table->increments('id_klaim');

            $table->unsignedInteger('id_barang');
            $table->unsignedInteger('id_pelapor');
            $table->unsignedInteger('id_admin')->nullable();

            $table->dateTime('tanggal_klaim')->useCurrent();
            $table->text('keterangan_privat');
            $table->string('status', 40)->default('Menunggu Verifikasi');
            $table->text('catatan_admin')->nullable();

            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('barang_ditemukan');

            $table->foreign('id_pelapor')
                ->references('id_pelapor')
                ->on('pelapor_kehilangan');

            $table->foreign('id_admin')
                ->references('id_admin')
                ->on('admin_kampus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klaim');
    }
};
