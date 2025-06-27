<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBidangToNotifikasiTable extends Migration
{
    public function up()
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            // Misal pakai string (contoh: "RPL", "TKJ", dll)
            $table->string('bidang')->nullable()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropColumn('bidang');
        });
    }
}

