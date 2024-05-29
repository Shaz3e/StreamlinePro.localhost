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
            ['name' => 'Low', 'text_color' => 'white', 'bg_color' => '#666666', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medium', 'text_color' => 'white', 'bg_color' => '#6aa84f', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'High', 'text_color' => 'white', 'bg_color' => 'magenta', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Urgent', 'text_color' => 'black', 'bg_color' => '#ff9900', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emergency', 'text_color' => 'white', 'bg_color' => '#cc0000', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Critical', 'text_color' => 'white', 'bg_color' => 'red', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('support_ticket_priorities')->insert($priorities);
    }
}
