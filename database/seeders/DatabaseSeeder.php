<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// TAMBAHKAN DUA BARIS INI
use App\Models\Mahasiswa;
use App\Models\Dosen;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            JurusanSeeder::class,
            ProdiSeeder::class,
        ]);

        // Sekarang baris ini tidak akan eror lagi
        Mahasiswa::factory(50)->create();
        Dosen::factory(10)->create();
    }
}
