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
            ['name' => 'Low'],
            ['name' => 'Medium'],
            ['name' => 'High'],
            ['name' => 'Urgent'],
            ['name' => 'Emergency'],
            ['name' => 'Critical'],
        ];

        DB::table('support_ticket_priorities')->insert($priorities);
    }
}
