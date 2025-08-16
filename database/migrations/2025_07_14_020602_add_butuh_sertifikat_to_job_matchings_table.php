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
            $table->boolean('butuh_sertifikat')->default(false)->after('status');
        });
    }

    public function down()
    {
        Schema::table('job_matchings', function (Blueprint $table) {
            $table->dropColumn('butuh_sertifikat');
        });
    }

};
