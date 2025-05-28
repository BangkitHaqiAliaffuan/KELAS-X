<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::factory()->count(100)->create()->each(function ($pelanggan) {
            $pelanggan->password = bcrypt('password123');
            $pelanggan->save();
        });
    }
}
