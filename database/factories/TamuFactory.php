<?php

namespace Database\Factories;

use App\Models\Tamu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tamu>
 */
class TamuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_lengkap'  => fake()->name(),
            'identity_number'  => fake()->unique()->numerify('################'), // 16 digit angka
            'no_telepon'      => fake()->phoneNumber(),
            'alamat'    => fake()->address(),
        ];
    }
}
