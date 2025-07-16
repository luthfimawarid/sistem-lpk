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
        Schema::table('job_matchings', function (Blueprint $table) {
            $table->string('bidang')->after('nama_perusahaan');
        });
    }

    public function down()
    {
        Schema::table('job_matchings', function (Blueprint $table) {
            $table->dropColumn('bidang');
        });
    }

};
