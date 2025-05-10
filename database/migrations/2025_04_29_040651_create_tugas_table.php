<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('tipe'); // ujian, tugas, kuis
            $table->string('cover')->nullable(); // gambar
            $table->date('deadline')->nullable();
            $table->enum('status', ['belum_selesai', 'selesai'])->default('belum_selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
