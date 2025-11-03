<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prodi')->delete(); // Hapus data lama dulu

        $jurusanElektro = DB::table('jurusan')->where('nama_jurusan', 'Teknik Elektro')->first();
        $jurusanMesin = DB::table('jurusan')->where('nama_jurusan', 'Teknik Mesin')->first();

        if ($jurusanElektro && $jurusanMesin) {
            DB::table('prodi')->insert([
                [
                    'jurusan_id' => $jurusanElektro->id,
                    'nama_prodi' => 'D4-Teknik Telekomunikasi',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'jurusan_id' => $jurusanMesin->id,
                    'nama_prodi' => 'D3-Teknik Mesin',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]);
        }
    }
}