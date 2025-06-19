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
        Schema::table('tugas', function (Blueprint $table) {
            $table->integer('durasi_menit')->nullable()->after('deadline');
        });
    }

    public function down()
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->dropColumn('durasi_menit');
        });
    }
};
