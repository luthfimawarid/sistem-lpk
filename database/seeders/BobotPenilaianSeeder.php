<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\BobotPenilaian;

class BobotPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BobotPenilaian::create([
            'jenis_penilaian' => 'tugas',
            'bobot' => 0, // Nilai default bisa 0 atau nilai awal lain
        ]);

        BobotPenilaian::create([
            'jenis_penilaian' => 'evaluasi_mingguan',
            'bobot' => 0,
        ]);

        BobotPenilaian::create([
            'jenis_penilaian' => 'tryout',
            'bobot' => 0,
        ]);
    }
}