<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Product 1', 'price' => 100, 'type' => 'product', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product 2', 'price' => 200, 'type' => 'product', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product 3', 'price' => 300, 'type' => 'product', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product 4', 'price' => 400, 'type' => 'product', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product 5', 'price' => 500, 'type' => 'product', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Service 1', 'price' => 100, 'type' => 'service', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Service 2', 'price' => 200, 'type' => 'service', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Service 3', 'price' => 300, 'type' => 'service', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Service 4', 'price' => 400, 'type' => 'service', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Service 5', 'price' => 500, 'type' => 'service', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('products_services')->insert($products);
    }
}
