<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tugas_user', function (Blueprint $table) {
            $table->integer('nilai')->nullable()->after('jawaban');
            $table->text('catatan')->nullable()->after('nilai');
        });
    }

    public function down(): void
    {
        Schema::table('tugas_user', function (Blueprint $table) {
            $table->dropColumn(['nilai', 'catatan']);
        });
    }
};
