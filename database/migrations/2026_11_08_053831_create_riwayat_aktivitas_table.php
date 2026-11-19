
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_aktivitas', function (Blueprint $table) {
            $table->increments('id_aktivitas');

            $table->unsignedInteger('id_super_admin')->nullable();
            $table->unsignedInteger('id_admin')->nullable();
            $table->unsignedInteger('id_satpam')->nullable();

            $table->string('tindakan', 160);
            $table->dateTime('waktu')->useCurrent();

            $table->string('referensi_jenis', 50)->nullable();
            $table->unsignedInteger('referensi_id')->nullable();

            $table->foreign('id_super_admin')
                ->references('id_super_admin')
                ->on('super_admin');

            $table->foreign('id_admin')
                ->references('id_admin')
                ->on('admin_kampus');

            $table->foreign('id_satpam')
                ->references('id_satpam')
                ->on('satpam');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_aktivitas');
    }
};
