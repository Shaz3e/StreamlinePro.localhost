<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Department 1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department 2', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department 3', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department 4', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('departments')->insert($departments);
    }
}
