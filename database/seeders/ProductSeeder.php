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
            ['name' => 'Product 1', 'price' => 100],
            ['name' => 'Product 2', 'price' => 100],
            ['name' => 'Product 3', 'price' => 100],
            ['name' => 'Product 4', 'price' => 100],
            ['name' => 'Product 5', 'price' => 100],
        ];
        DB::table('products')->insert($products);
    }
}
