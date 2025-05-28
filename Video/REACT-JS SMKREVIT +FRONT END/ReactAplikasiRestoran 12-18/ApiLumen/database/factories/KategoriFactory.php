<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategori>
 */
class KategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategoriList = [
            'Makanan Utama', 'Makanan Ringan', 'Makanan Penutup',
            'Makanan Pembuka', 'Makanan Tradisional', 'Makanan Internasional',
            'Minuman Panas', 'Minuman Dingin', 'Minuman Tradisional',
            'Jus Buah', 'Smoothies', 'Kopi', 'Teh',
            'Makanan Vegetarian', 'Makanan Laut', 'Makanan Pedas',
            'Makanan Bakar', 'Makanan Goreng', 'Makanan Rebus',
            'Minuman Soda', 'Minuman Beralkohol', 'Minuman Sehat',
            'Makanan Kekinian', 'Makanan Diet', 'Makanan Organik'
        ];

        return [
            'kategori' => $this->faker->unique()->randomElement($kategoriList),
            'keterangan' => $this->faker->sentence()
        ];
    }
}
