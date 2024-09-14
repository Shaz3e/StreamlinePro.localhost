<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Staff\StoreStaffRequest;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Task;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', Admin::class);

        return view('admin.staff.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', Admin::class);

        // Get active departments
        $departments = Department::where('is_active', 1)->get();

        // Get roles
        $roles = Role::pluck('name', 'name')->all();

        return view('admin.staff.create', [
            'departments' => $departments,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', Admin::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $staff = Admin::create($validated);

        // Attach department
        if ($request->department_id) {
            $staff->departments()->attach($request->department_id);
        }

        // Sync Role
        $staff->syncRoles($request->roles);

        session()->flash('success', 'Staff created successfully!');

        return $this->saveAndRedirect($request, 'staff', $staff->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $staff)
    {
        // Check Authorize
        Gate::authorize('read', $staff);

        if ($staff->id === 1) {
            session()->flash('error', 'You cannot view super admin!');
            return redirect()->route('admin.staff.index');
        }

        $audits = $staff->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.staff.show', [
            'staff' => $staff,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $staff)
    {
        // Check Authorize
        Gate::authorize('update', $staff);

        if ($staff->id === 1) {
            session()->flash('error', 'You cannot edit the super admin!');
            return redirect()->route('admin.staff.index');
        }

        // Get active departments
        $departments = Department::where('is_active', 1)->get();

        // Get roles
        $roles = Role::pluck('name', 'name')->all();

        // Staff Role(s)
        $staffRoles = $staff->roles()->pluck('name', 'name')->all();

        return view('admin.staff.edit', [
            'staff' => $staff,
            'departments' => $departments,
            'roles' => $roles,
            'staffRoles' => $staffRoles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreStaffRequest $request, Admin $staff)
    {
        // Check Authorize
        Gate::authorize('update', $staff);

        if ($staff->id === 1) {
            session()->flash('error', 'You cannot edit the super admin!');
            return redirect()->route('admin.staff.index');
        }

        // Validate data
        $validated = $request->validated();

        // Check if pasword is filled
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        // Update record in database
        $staff->update($validated);

        // Sync Role
        $staff->syncRoles($request->roles);

        // Attach department
        if ($request->department_id) {
            $staff->departments()->sync($request->department_id);
        }

        // Flash message
        session()->flash('success', 'Staff updated successfully!');

        return $this->saveAndRedirect($request, 'staff', $staff->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', Admin::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.staff.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.staff.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('delete', Admin::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.staff.index');
    }

    /**
     * Search Staff
     */
    public function searchStaff(Request $request)
    {
        $term = $request->input('term');
        $admins = Admin::where('name', 'like', '%' . $term . '%')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'results' => $admins->map(function ($admin) {
                return [
                    'id' => $admin->id,
                    'text' => $admin->name
                ];
            })
        ]);
    }
}
