<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // HAPUS / KOMENTAR default factory:
        // \App\Models\User::factory(10)->create();

        // JALANKAN HANYA MASTER SEEDER
        $this->call(MasterSeeder::class);
    }
}