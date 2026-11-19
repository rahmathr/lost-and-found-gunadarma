<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_verification_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_pelapor')->unique();
            $table->string('code_hash', 255);
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->foreign('id_pelapor')->references('id_pelapor')->on('pelapor_kehilangan')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_verification_codes');
    }
};
