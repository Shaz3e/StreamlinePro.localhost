<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $task_statuses = [
            [
                'name' => 'Not Started',
                'is_active' => 1,
            ],
            [
                'name' => 'In Progress',
                'is_active' => 1,
            ],
            [
                'name' => 'Completed',
                'is_active' => 1,
            ],
            [
                'name' => 'On Hold',
                'is_active' => 1,
            ],
            [
                'name' => 'Pending',
                'is_active' => 1,
            ],
            [
                'name' => 'Cancelled',
                'is_active' => 1,
            ],
            [
                'name' => 'Waiting for Approval',
                'is_active' => 1,
            ],
            [
                'name' => 'Needs Review',
                'is_active' => 1,
            ],
            [
                'name' => 'Scheduled',
                'is_active' => 1,
            ],
            [
                'name' => 'In Review',
                'is_active' => 1,
            ],
            [
                'name' => 'Overdue',
                'is_active' => 1,
            ],
        ];
        
        DB::table('task_statuses')->insert($task_statuses);
    }
}
