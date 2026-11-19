
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satpam', function (Blueprint $table) {
            $table->increments('id_satpam');

            $table->unsignedInteger('id_kampus');

            $table->string('nama', 100);
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255);

            $table->foreign('id_kampus')
                ->references('id_kampus')
                ->on('kampus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satpam');
    }
};
