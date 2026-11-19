<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_laporan_kehilangan', function (Blueprint $table) {
            $table->bigIncrements('id_foto_laporan');
            $table->unsignedInteger('id_laporan');
            $table->string('path_foto', 255);
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_laporan')
                ->references('id_laporan')
                ->on('laporan_kehilangan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_laporan_kehilangan');
    }
};
