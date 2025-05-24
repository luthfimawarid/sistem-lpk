<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dokumen_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jenis_dokumen'); // paspor, visa, dll
            $table->string('file'); // path dokumen
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('dokumen_siswa');
    }

};
