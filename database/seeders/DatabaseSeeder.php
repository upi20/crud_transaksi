<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Product::insert([
            ['produk' => 'Laptop ASUS', 'stok' => 10, 'harga' => 15000000],
            ['produk' => 'Mouse Logitech', 'stok' => 20, 'harga' => 250000],
            ['produk' => 'Keyboard Mechanical', 'stok' => 15, 'harga' => 800000],
            ['produk' => 'Monitor 24 inch', 'stok' => 5, 'harga' => 2000000],
            ['produk' => 'Headset Gaming', 'stok' => 8, 'harga' => 1200000],
        ]);
    }
}
