<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelangganFactory extends Factory
{
    protected $model = Pelanggan::class;

    public function definition(): array
    {
        return [
            'pelanggan' => fake()->name(),
            'alamat' => fake()->address(),
            'telp' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password123', // password tanpa hash sesuai permintaan
        ];
    }
}
