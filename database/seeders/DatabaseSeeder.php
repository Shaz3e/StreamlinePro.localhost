<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(1000)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminSeeder::class,
            SupportTicketProiritySeeder::class,
            SupportTicketStatusSeeder::class,
            TaskStatusSeeder::class,
            TodoLabelSeeder::class,
            InvoiceStatusSeeder::class,

            // Local
            ProductSeeder::class,
            CompanySeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,

            // Run this seeder at the end
            RolePermissionSeeder::class,
        ]);
    }
}
