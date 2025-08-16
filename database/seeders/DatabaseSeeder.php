<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\BobotPenilaianSeeder; // Import seeder yang baru dibuat

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder lain di sini
        $this->call([
            BobotPenilaianSeeder::class,
            // Jika Anda memiliki seeder lain (misalnya UserSeeder), panggil di sini juga
            // UserSeeder::class,
        ]);
        
        // Kode factory Anda yang sebelumnya
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}