<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupportTicketProiritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            ['name' => 'Low', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medium', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'High', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Urgent', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emergency', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Critical', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('support_ticket_priorities')->insert($priorities);
    }
}
