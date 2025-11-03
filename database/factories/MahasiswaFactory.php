<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prodi;
use App\Models\User;

class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);

        return [
            'user_id' => $user->id,
            'mhs_nama' => $user->name,
            'prodi_id' => Prodi::inRandomOrder()->first()->id,
            'mhs_nim' => fake()->unique()->numerify('11012####'),
            'tahun_masuk' => fake()->year(),
        ];
    }
}