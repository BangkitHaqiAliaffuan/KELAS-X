<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Original', 'slug' => 'original'],
            ['name' => 'Spicy', 'slug' => 'spicy'],
            ['name' => 'Flying Chicken', 'slug' => 'flying-chicken'],
            ['name' => 'Minuman', 'slug' => 'minuman'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
