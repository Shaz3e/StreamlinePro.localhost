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
                'first_name' => 'User',
                'last_name' => 'One',
                'name' => 'User One',
                'email' => 'user1@shaz3e.com',
                'password' => Hash::make('123456789'),
                'company_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'User',
                'last_name' => 'Two',
                'name' => 'User Two',
                'email' => 'user2@shaz3e.com',
                'password' => Hash::make('123456789'),
                'company_id' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'User',
                'last_name' => 'Three',
                'name' => 'User Three',
                'email' => 'user3@shaz3e.com',
                'password' => Hash::make('123456789'),
                'company_id' => 3,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'User',
                'last_name' => 'Four',
                'name' => 'User Four',
                'email' => 'user4@shaz3e.com',
                'password' => Hash::make('123456789'),
                'company_id' => 4,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'User',
                'last_name' => 'Five',
                'name' => 'User Five',
                'email' => 'user5@shaz3e.com',
                'password' => Hash::make('123456789'),
                'company_id' => 5,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('users')->insert($users);
    }
}
