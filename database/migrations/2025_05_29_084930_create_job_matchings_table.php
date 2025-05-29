<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_matchings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('posisi');
            $table->string('lokasi');
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('terbuka'); // bisa: terbuka, ditutup, dilamar
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_matchings');
    }
};
