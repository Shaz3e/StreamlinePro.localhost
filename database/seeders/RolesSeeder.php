<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['guard_name' => 'admin', 'name' => 'superadmin'],
            ['guard_name' => 'admin', 'name' => 'tester'],
            ['guard_name' => 'admin', 'name' => 'developer'],
            ['guard_name' => 'admin', 'name' => 'admin'],
            ['guard_name' => 'admin', 'name' => 'manager'],
            ['guard_name' => 'admin', 'name' => 'staff'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }

        // Assign roles to specific users if needed
        $this->assignRolesToUsers();
    }

    protected function assignRolesToUsers(): void
    {
        $users = [
            'superadmin@shaz3e.com' => 'superadmin',
            'tester@shaz3e.com' => 'tester',
            'developer@shaz3e.com' => 'developer',
            'admin@shaz3e.com' => 'admin',
            'manager@shaz3e.com' => 'manager',
            'staff@shaz3e.com' => 'staff',
        ];

        foreach ($users as $email => $roleName) {
            $user = Admin::where('email', $email)->first();
            if ($user) {
                $user->assignRole($roleName);
            }
        }
    }
}
