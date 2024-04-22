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
            ['name' => 'Department 1'],
            ['name' => 'Department 2'],
            ['name' => 'Department 3'],
            ['name' => 'Department 4'],
        ];

        DB::table('departments')->insert($departments);
    }
}
