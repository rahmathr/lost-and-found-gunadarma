<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_barang_ditemukan', function (Blueprint $table) {
            $table->bigIncrements('id_foto');
            $table->unsignedInteger('id_barang');
            $table->string('path_foto', 255);
            $table->boolean('is_utama')->default(false);
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('barang_ditemukan')
                ->onDelete('cascade');

            $table->index(['id_barang', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_barang_ditemukan');
    }
};
