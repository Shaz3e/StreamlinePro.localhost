<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $roles = [
            ['guard_name' => 'admin', 'name' => 'superadmin'],
            ['guard_name' => 'admin', 'name' => 'admin'],
            ['guard_name' => 'admin', 'name' => 'manager'],
            ['guard_name' => 'admin', 'name' => 'staff'],
        ];

        foreach ($roles as $role) {
            $newRole = Role::create($role);

            // Assign Roles to Users
            if ($newRole->name === 'superadmin') {
                $admin = Admin::where('email', 'superadmin@shaz3e.com')->first();
                $admin->assignRole($newRole);
            } elseif ($newRole->name === 'admin') {
                $admin = Admin::where('email', 'admin@shaz3e.com')->first();
                $admin->assignRole($newRole);
            } elseif ($newRole->name === 'manager') {
                $admin = Admin::where('email', 'manager@shaz3e.com')->first();
                $admin->assignRole($newRole);
            } elseif ($newRole->name === 'staff') {
                $admin = Admin::where('email', 'staff@shaz3e.com')->first();
                $admin->assignRole($newRole);
            }
        }

        // Create all permissions
        $permissions = [
            // User
            ['guard_name' => 'admin', 'name' => 'user.list'],
            ['guard_name' => 'admin', 'name' => 'user.create'],
            ['guard_name' => 'admin', 'name' => 'user.read'],
            ['guard_name' => 'admin', 'name' => 'user.update'],
            ['guard_name' => 'admin', 'name' => 'user.delete'],
            ['guard_name' => 'admin', 'name' => 'user.restore'],
            ['guard_name' => 'admin', 'name' => 'user.force.delete'],
            // Company
            ['guard_name' => 'admin', 'name' => 'company.list'],
            ['guard_name' => 'admin', 'name' => 'company.create'],
            ['guard_name' => 'admin', 'name' => 'company.read'],
            ['guard_name' => 'admin', 'name' => 'company.update'],
            ['guard_name' => 'admin', 'name' => 'company.delete'],
            ['guard_name' => 'admin', 'name' => 'company.restore'],
            ['guard_name' => 'admin', 'name' => 'company.force.delete'],
            // staff
            ['guard_name' => 'admin', 'name' => 'staff.list'],
            ['guard_name' => 'admin', 'name' => 'staff.create'],
            ['guard_name' => 'admin', 'name' => 'staff.read'],
            ['guard_name' => 'admin', 'name' => 'staff.update'],
            ['guard_name' => 'admin', 'name' => 'staff.delete'],
            ['guard_name' => 'admin', 'name' => 'staff.restore'],
            ['guard_name' => 'admin', 'name' => 'staff.force.delete'],
            // Department
            ['guard_name' => 'admin', 'name' => 'department.list'],
            ['guard_name' => 'admin', 'name' => 'department.create'],
            ['guard_name' => 'admin', 'name' => 'department.read'],
            ['guard_name' => 'admin', 'name' => 'department.update'],
            ['guard_name' => 'admin', 'name' => 'department.delete'],
            ['guard_name' => 'admin', 'name' => 'department.restore'],
            ['guard_name' => 'admin', 'name' => 'department.force.delete'],
            // Promotion
            ['guard_name' => 'admin', 'name' => 'promotion.list'],
            ['guard_name' => 'admin', 'name' => 'promotion.create'],
            ['guard_name' => 'admin', 'name' => 'promotion.read'],
            ['guard_name' => 'admin', 'name' => 'promotion.update'],
            ['guard_name' => 'admin', 'name' => 'promotion.delete'],
            ['guard_name' => 'admin', 'name' => 'promotion.restore'],
            ['guard_name' => 'admin', 'name' => 'promotion.force.delete'],
            // Product
            ['guard_name' => 'admin', 'name' => 'product.list'],
            ['guard_name' => 'admin', 'name' => 'product.create'],
            ['guard_name' => 'admin', 'name' => 'product.read'],
            ['guard_name' => 'admin', 'name' => 'product.update'],
            ['guard_name' => 'admin', 'name' => 'product.delete'],
            ['guard_name' => 'admin', 'name' => 'product.restore'],
            ['guard_name' => 'admin', 'name' => 'product.force.delete'],
            // Role
            ['guard_name' => 'admin', 'name' => 'role.list'],
            ['guard_name' => 'admin', 'name' => 'role.create'],
            ['guard_name' => 'admin', 'name' => 'role.read'],
            ['guard_name' => 'admin', 'name' => 'role.update'],
            ['guard_name' => 'admin', 'name' => 'role.delete'],
            ['guard_name' => 'admin', 'name' => 'role.restore'],
            ['guard_name' => 'admin', 'name' => 'role.force.delete'],
            // Permission
            ['guard_name' => 'admin', 'name' => 'permission.list'],
            ['guard_name' => 'admin', 'name' => 'permission.create'],
            ['guard_name' => 'admin', 'name' => 'permission.read'],
            ['guard_name' => 'admin', 'name' => 'permission.update'],
            ['guard_name' => 'admin', 'name' => 'permission.delete'],
            ['guard_name' => 'admin', 'name' => 'permission.restore'],
            ['guard_name' => 'admin', 'name' => 'permission.force.delete'],
            // Todo
            ['guard_name' => 'admin', 'name' => 'todo.list'],
            ['guard_name' => 'admin', 'name' => 'todo.create'],
            ['guard_name' => 'admin', 'name' => 'todo.read'],
            ['guard_name' => 'admin', 'name' => 'todo.update'],
            ['guard_name' => 'admin', 'name' => 'todo.delete'],
            ['guard_name' => 'admin', 'name' => 'todo.restore'],
            ['guard_name' => 'admin', 'name' => 'todo.force.delete'],
            // Todo Status
            ['guard_name' => 'admin', 'name' => 'todo-status.list'],
            ['guard_name' => 'admin', 'name' => 'todo-status.create'],
            ['guard_name' => 'admin', 'name' => 'todo-status.read'],
            ['guard_name' => 'admin', 'name' => 'todo-status.update'],
            ['guard_name' => 'admin', 'name' => 'todo-status.delete'],
            ['guard_name' => 'admin', 'name' => 'todo-status.restore'],
            ['guard_name' => 'admin', 'name' => 'todo-status.force.delete'],
            // Task
            ['guard_name' => 'admin', 'name' => 'task.list'],
            ['guard_name' => 'admin', 'name' => 'task.create'],
            ['guard_name' => 'admin', 'name' => 'task.read'],
            ['guard_name' => 'admin', 'name' => 'task.update'],
            ['guard_name' => 'admin', 'name' => 'task.delete'],
            ['guard_name' => 'admin', 'name' => 'task.restore'],
            ['guard_name' => 'admin', 'name' => 'task.force.delete'],
            // Task Status
            ['guard_name' => 'admin', 'name' => 'task-status.list'],
            ['guard_name' => 'admin', 'name' => 'task-status.create'],
            ['guard_name' => 'admin', 'name' => 'task-status.read'],
            ['guard_name' => 'admin', 'name' => 'task-status.update'],
            ['guard_name' => 'admin', 'name' => 'task-status.delete'],
            ['guard_name' => 'admin', 'name' => 'task-status.restore'],
            ['guard_name' => 'admin', 'name' => 'task-status.force.delete'],
            // Support Ticket
            ['guard_name' => 'admin', 'name' => 'support-ticket.list'],
            ['guard_name' => 'admin', 'name' => 'support-ticket.create'],
            ['guard_name' => 'admin', 'name' => 'support-ticket.read'],
            ['guard_name' => 'admin', 'name' => 'support-ticket.update'],
            ['guard_name' => 'admin', 'name' => 'support-ticket.delete'],
            ['guard_name' => 'admin', 'name' => 'support-ticket.restore'],
            ['guard_name' => 'admin', 'name' => 'support-ticket.force.delete'],
            // Support Ticket Status
            ['guard_name' => 'admin', 'name' => 'ticket-status.list'],
            ['guard_name' => 'admin', 'name' => 'ticket-status.create'],
            ['guard_name' => 'admin', 'name' => 'ticket-status.read'],
            ['guard_name' => 'admin', 'name' => 'ticket-status.update'],
            ['guard_name' => 'admin', 'name' => 'ticket-status.delete'],
            ['guard_name' => 'admin', 'name' => 'ticket-status.restore'],
            ['guard_name' => 'admin', 'name' => 'ticket-status.force.delete'],
            // Support Ticket Priority
            ['guard_name' => 'admin', 'name' => 'ticket-priority.list'],
            ['guard_name' => 'admin', 'name' => 'ticket-priority.create'],
            ['guard_name' => 'admin', 'name' => 'ticket-priority.read'],
            ['guard_name' => 'admin', 'name' => 'ticket-priority.update'],
            ['guard_name' => 'admin', 'name' => 'ticket-priority.delete'],
            ['guard_name' => 'admin', 'name' => 'ticket-priority.restore'],
            ['guard_name' => 'admin', 'name' => 'ticket-priority.force.delete'],
            // Invoice
            ['guard_name' => 'admin', 'name' => 'invoice.list'],
            ['guard_name' => 'admin', 'name' => 'invoice.create'],
            ['guard_name' => 'admin', 'name' => 'invoice.read'],
            ['guard_name' => 'admin', 'name' => 'invoice.update'],
            ['guard_name' => 'admin', 'name' => 'invoice.delete'],
            ['guard_name' => 'admin', 'name' => 'invoice.restore'],
            ['guard_name' => 'admin', 'name' => 'invoice.force.delete'],
            // Invoice Status
            ['guard_name' => 'admin', 'name' => 'invoice-status.list'],
            ['guard_name' => 'admin', 'name' => 'invoice-status.create'],
            ['guard_name' => 'admin', 'name' => 'invoice-status.read'],
            ['guard_name' => 'admin', 'name' => 'invoice-status.update'],
            ['guard_name' => 'admin', 'name' => 'invoice-status.delete'],
            ['guard_name' => 'admin', 'name' => 'invoice-status.restore'],
            ['guard_name' => 'admin', 'name' => 'invoice-status.force.delete'],
            // Add more permissions here...
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Assign permissions to superadmin
        $superAdminRole = Role::where('guard_name', 'admin')->where('name', 'superadmin')->first();
        $superAdminRole->givePermissionTo(Permission::all());

        // Assign permissions to admin
        $adminRole = Role::where('guard_name', 'admin')->where('name', 'admin')->first();
        $adminRole->givePermissionTo(
            Permission::where('name', 'NOT LIKE', '%restore%')
                ->where('name', 'NOT LIKE', '%force.delete%')
                ->get()
        );

        $managerRole = Role::where('guard_name', 'admin')->where('name', 'manager')->first();
        $managerRole->givePermissionTo(
            Permission::where('name', 'NOT LIKE', '%delete%')
                ->where('name', 'NOT LIKE', '%restore%')
                ->where('name', 'NOT LIKE', '%force.delete%')
                ->get()
        );

        $staffRole = Role::where('guard_name', 'admin')->where('name', 'staff')->first();
        $staffRole->givePermissionTo(
            Permission::where('name', 'NOT LIKE', '%create%')
                ->where('name', 'NOT LIKE', '%update')
                ->where('name', 'NOT LIKE', '%delete')
                ->where('name', 'NOT LIKE', '%restore')
                ->where('name', 'NOT LIKE', '%force.delete%')
                ->get()
        );
    }
}
