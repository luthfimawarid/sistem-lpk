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
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->string('bidang')->nullable(); // misalnya: Pengolahan Makanan
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            //
        });
    }
};
