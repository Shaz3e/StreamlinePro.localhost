<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $todo_statuses = [
            ['name' => 'Pending', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'In Progress', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Completed', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'On Hold', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cancelled', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Deferred', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Not Started', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Urgent', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'High Priority', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Low Priority', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('todo_statuses')->insert($todo_statuses);
    }
}
