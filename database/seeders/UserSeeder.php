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
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@email.com',
                'password' => Hash::make('password'),
                'company_id' => 2,
            ],
            [
                'name' => 'User 3',
                'email' => 'user3@email.com',
                'password' => Hash::make('password'),
                'company_id' => 3,
            ],
            [
                'name' => 'User 4',
                'email' => 'user4@email.com',
                'password' => Hash::make('password'),
                'company_id' => 4,
            ],
            [
                'name' => 'User 5',
                'email' => 'user5@email.com',
                'password' => Hash::make('password'),
                'company_id' => 5,
            ],
        ];
        DB::table('users')->insert($users);
    }
}
