
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyerahan', function (Blueprint $table) {
            $table->increments('id_penyerahan');

            $table->unsignedInteger('id_klaim')->unique();
            $table->unsignedInteger('id_admin');

            $table->dateTime('tanggal_penyerahan')->useCurrent();
            $table->text('catatan')->nullable();

            $table->foreign('id_klaim')
                ->references('id_klaim')
                ->on('klaim');

            $table->foreign('id_admin')
                ->references('id_admin')
                ->on('admin_kampus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyerahan');
    }
};
