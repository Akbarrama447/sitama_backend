<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prodi;
use App\Models\User;

class DosenFactory extends Factory
{
    public function definition(): array
    {
        $user = User::factory()->create(['role' => 'dosen']);

        return [
            'user_id' => $user->id,
            'dosen_nama' => $user->name,
            'prodi_id' => Prodi::inRandomOrder()->first()->id,
            'dosen_nip' => fake()->unique()->numerify('198#########'), // Sesuai kesepakatan kita
        ];
    }
}