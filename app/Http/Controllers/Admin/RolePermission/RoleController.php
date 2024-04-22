<?php

namespace App\Http\Controllers\Admin\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // All rolex except superadmin
        $roles = Role::where('name', '!=', 'superadmin')->get();

        return view('admin.role-permission.role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.role-permission.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name'
            ],
        ]);

        // $validated = $request->validate();
        Role::create($validated);

        session()->flash('success', 'Role has been created successfully');

        return redirect()->route('admin.roles-permissions.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return redirect()->route('admin.roles-permissions.roles.edit', $role->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // Restricted to edit super admin role
        if($role->name === 'superadmin'){
            session()->flash('error', 'You cannot edit the superadmin role');
            return redirect()->route('admin.roles-permissions.roles.index');
        }
        
        $permissions = Permission::all();

        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('admin.role-permission.role.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // Restricted to edit super admin role
        if($role->name === 'superadmin'){
            session()->flash('error', 'You cannot edit the superadmin role');
            return redirect()->route('admin.roles-permissions.roles.index');
        }

        if ($request->has('syncPermissions')) {
            $request->validate([
                'permissions' => 'required',
            ]);
            if ($role) {
                $role->syncPermissions($request->permissions);
                session()->flash('success', 'Permission has been updated successfully');
                return back();
            }
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name,' . $role->id,
            ],
        ]);

        // $validated = $request->validate();
        $role->update($validated);

        session()->flash('success', 'Permission has been updated successfully');

        return redirect()->route('admin.roles-permissions.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Restricted to edit super admin role
        if($role->name === 'superadmin'){
            session()->flash('error', 'You cannot edit the superadmin role');
            return redirect()->route('admin.roles-permissions.roles.index');
        }
        
        if ($role) {
            $role->delete();
            session()->flash('success', 'Role has been deleted successfully');
            return redirect()->route('admin.roles-permissions.roles.index');
        }

        session()->flash('error', 'Role not found');
        return redirect()->route('admin.roles-permissions.roles.index');
    }
}
