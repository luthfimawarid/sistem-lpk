<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('soal_kuis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tugas_id'); // relasi ke tugas
            $table->text('pertanyaan');
            $table->string('opsi_a');
            $table->string('opsi_b');
            $table->string('opsi_c');
            $table->string('opsi_d');
            $table->string('jawaban'); // nilai: a, b, c, atau d
            $table->timestamps();

            $table->foreign('tugas_id')->references('id')->on('tugas')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('soal_kuis');
    }
};

