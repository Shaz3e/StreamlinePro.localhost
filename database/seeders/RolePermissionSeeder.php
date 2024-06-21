<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define role-based permissions
        $rolePermissions = [
            'superadmin' => Permission::all(),
            'tester' => Permission::all(),
            'developer' => Permission::all(),
            'admin' => Permission::whereNotIn('name', ['%restore%', '%force.delete%'])->get(),
            'manager' => Permission::whereNotIn('name', ['%delete%', '%restore%', '%force.delete%'])->get(),
            'staff' => Permission::whereNotIn('name', ['%create%', '%update%', '%delete%', '%restore%', '%force.delete%'])->get(),
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->syncPermissions($permissions);
            }
        }
    }
}
