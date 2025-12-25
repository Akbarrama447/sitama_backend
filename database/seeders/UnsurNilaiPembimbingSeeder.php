<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UnsurNilaiPembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kosongkan tabel dulu biar tidak duplikat (Opsional)
        // DB::table('unsur_nilai_pembimbing')->truncate();

        $data = [
            [
                'id' => 1, 
                'nama_unsur' => 'Kedisiplinan', 
                'bobot' => 25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2, 
                'nama_unsur' => 'Kreativitas', 
                'bobot' => 25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3, 
                'nama_unsur' => 'Penguasaan Materi', 
                'bobot' => 25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4, 
                'nama_unsur' => 'Kelengkapan', 
                'bobot' => 25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('unsur_nilai_pembimbing')->insert($data);
    }
}