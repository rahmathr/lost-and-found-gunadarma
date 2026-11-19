<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelapor_kehilangan', function (Blueprint $table) {
            $table->increments('id_pelapor');
            $table->string('nama', 100);
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelapor_kehilangan');
    }
};
