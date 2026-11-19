
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_kampus', function (Blueprint $table) {
            $table->increments('id_admin');

            $table->unsignedInteger('id_kampus');
            $table->unsignedInteger('id_super_admin_pembuat');

            $table->string('nama', 100);
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255);

            $table->foreign('id_kampus')
                ->references('id_kampus')
                ->on('kampus');

            $table->foreign('id_super_admin_pembuat')
                ->references('id_super_admin')
                ->on('super_admin');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_kampus');
    }
};
