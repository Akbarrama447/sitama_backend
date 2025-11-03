<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <--- PENTING: Jangan lupa tambahkan ini

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan Query Builder untuk memasukkan data
        DB::table('jurusan')->insert([
            [
                'nama_jurusan' => 'Teknik Elektro',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_jurusan' => 'Teknik Mesin',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}