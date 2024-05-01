<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $todo_labels = [
            ['name' => 'Pending', 'text_color' => 'white', 'bg_color' => 'blue', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'In Progress', 'text_color' => 'black', 'bg_color' => 'cyan', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Completed', 'text_color' => 'white', 'bg_color' => '#6aa84f', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'On Hold', 'text_color' => 'white', 'bg_color' => 'lime', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Cancelled', 'text_color' => 'black', 'bg_color' => '#f9cb9c', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Deferred', 'text_color' => 'black', 'bg_color' => '#ead1dc', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Not Started', 'text_color' => 'white', 'bg_color' => '#a64d79', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Urgent', 'text_color' => 'black', 'bg_color' => '#ff9900', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'High Priority', 'text_color' => 'white', 'bg_color' => 'red', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Low Priority', 'text_color' => 'white', 'bg_color' => '#e06666', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now(),],
        ];

        DB::table('todo_labels')->insert($todo_labels);
    }
}
