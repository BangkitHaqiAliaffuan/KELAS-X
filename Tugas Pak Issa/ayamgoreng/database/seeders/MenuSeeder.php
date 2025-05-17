<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Ambil ID kategori
        $original = Category::where('slug', 'original')->first()->id;
        $spicy = Category::where('slug', 'spicy')->first()->id;
        $flying = Category::where('slug', 'flying-chicken')->first()->id;
        $minuman = Category::where('slug', 'minuman')->first()->id;

        // Menu untuk kategori Original
        Menu::create([
            'category_id' => $original,
            'name' => 'Ayam Original 1 Potong',
            'description' => 'Ayam goreng dengan tepung crispy original, renyah di luar dan juicy di dalam.',
            'price' => 25000,
            'image' => 'gambar/ayamkrispi.webp',
        ]);

        Menu::create([
            'category_id' => $original,
            'name' => 'Ayam Original 2 Potong',
            'description' => 'Paket hemat dengan 2 potong ayam goreng original crispy.',
            'price' => 45000,
            'image' => 'gambar/ayamkrispi.webp',
        ]);

        // Menu untuk kategori Spicy
        Menu::create([
            'category_id' => $spicy,
            'name' => 'Ayam Spicy 1 Potong',
            'description' => 'Ayam goreng dengan balutan tepung dan bumbu pedas yang menggugah selera.',
            'price' => 27000,
            'image' => 'gambar/ayampedas.webp',
        ]);

        Menu::create([
            'category_id' => $spicy,
            'name' => 'Ayam Spicy 2 Potong',
            'description' => 'Paket hemat dengan 2 potong ayam goreng spicy pedas.',
            'price' => 48000,
            'image' => 'gambar/ayampedas.webp',
        ]);

        // Menu untuk kategori Flying Chicken
        Menu::create([
            'category_id' => $flying,
            'name' => 'Paket Flying 1',
            'description' => '3 potong ayam, 2 nasi, dan 2 minuman segar pilihan.',
            'price' => 75000,
            'image' => 'gambar/paketkeluarga.webp',
        ]);

        Menu::create([
            'category_id' => $flying,
            'name' => 'Paket Flying 2',
            'description' => '5 potong ayam, 3 nasi, dan 3 minuman segar pilihan untuk keluarga tercinta.',
            'price' => 120000,
            'image' => 'gambar/paketkeluarga.webp',
        ]);

        // Menu untuk kategori Minuman
        Menu::create([
            'category_id' => $minuman,
            'name' => 'Es Teh Manis',
            'description' => 'Teh manis segar dengan es batu, cocok menemani santap ayam goreng.',
            'price' => 8000,
            'image' => 'gambar/esteh.jpg',
        ]);

        Menu::create([
            'category_id' => $minuman,
            'name' => 'Es Jeruk',
            'description' => 'Jeruk segar diperas langsung dengan tambahan es batu dan sedikit gula.',
            'price' => 10000,
            'image' => 'gambar/esjeruk.jpg',
        ]);
    }
}
