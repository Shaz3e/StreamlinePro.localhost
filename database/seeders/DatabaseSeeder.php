<?php

namespace Database\Seeders;

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
            // Required Seeders
            AdminSeeder::class,
            SupportTicketProiritySeeder::class,
            SupportTicketStatusSeeder::class,
            TaskLabelSeeder::class,
            TodoLabelSeeder::class,
            InvoiceLabelSeeder::class,

            // Local
            ProductServiceSeeder::class,
            CompanySeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            KnowledgebaseCategorySeeder::class,

            // Seeders for Users and Currency
            CurrencySeeder::class,
            CountrySeeder::class,

            // App Settings Required
            AppSettingSeeder::class,

            // Create Permissions
            PermissionsSeeder::class,

            // Create Roles
            RolesSeeder::class,

            // Sync Roles & Permissions
            RolePermissionSeeder::class,
        ]);
    }
}
