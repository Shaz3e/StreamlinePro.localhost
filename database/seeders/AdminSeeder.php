<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@shaz3e.com',
                'password' => Hash::make('123456789'),
                'is_active' => 1,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@shaz3e.com',
                'password' => Hash::make('123456789'),
                'is_active' => 1,
            ],
            [
                'name' => 'manager',
                'email' => 'manager@shaz3e.com',
                'password' => Hash::make('123456789'),
                'is_active' => 1,
            ],
            [
                'name' => 'staff',
                'email' => 'staff@shaz3e.com',
                'password' => Hash::make('123456789'),
                'is_active' => 1,
            ],
        ];

        DB::table('admins')->insert($admins);
    }
}
