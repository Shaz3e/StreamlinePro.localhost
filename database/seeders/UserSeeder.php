<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'User 1',
                'email' => 'user1@email.com',
                'password' => Hash::make('password'),
                'company_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@email.com',
                'password' => Hash::make('password'),
                'company_id' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User 3',
                'email' => 'user3@email.com',
                'password' => Hash::make('password'),
                'company_id' => 3,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User 4',
                'email' => 'user4@email.com',
                'password' => Hash::make('password'),
                'company_id' => 4,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User 5',
                'email' => 'user5@email.com',
                'password' => Hash::make('password'),
                'company_id' => 5,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('users')->insert($users);
    }
}
