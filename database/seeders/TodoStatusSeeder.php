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
            ['name' => 'Pending', 'is_active' => 1],
            ['name' => 'In Progress', 'is_active' => 1],
            ['name' => 'Completed', 'is_active' => 1],
            ['name' => 'On Hold', 'is_active' => 1],
            ['name' => 'Cancelled', 'is_active' => 1],
            ['name' => 'Deferred', 'is_active' => 1],
            ['name' => 'Not Started', 'is_active' => 1],
            ['name' => 'Urgent', 'is_active' => 1],
            ['name' => 'High Priority', 'is_active' => 1],
            ['name' => 'Low Priority', 'is_active' => 1],
        ];

        DB::table('todo_statuses')->insert($todo_statuses);
    }
}
