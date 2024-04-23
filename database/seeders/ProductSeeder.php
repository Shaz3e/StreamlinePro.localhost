<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Product 1', 'price' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product 2', 'price' => 200, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product 3', 'price' => 300, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product 4', 'price' => 400, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product 5', 'price' => 500, 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('products')->insert($products);
    }
}
