<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Staff\StoreStaffRequest;
use App\Models\Admin;
use App\Models\Department;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.staff.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        // Validate data
        $validated = $request->validated();

        // Update record in database
        $staff = Admin::create($validated);

        // Sync Role
        $staff->syncRoles($request->roles);

        session()->flash('success', 'Staff created successfully!');

        return redirect()->route('admin.staff.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $staff)
    {
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

        // Send password to staff if required create this functionality
        // if ($request->filled('password')) {
        //     $mailData = [
        //         'url' => config('app.url'),
        //         'name' => $staff->name,
        //         'email' => $staff->email,
        //         'password' => $request->password,
        //     ];

        //     // Mail::to($mailData['email'])->send(new PasswordReset($mailData));
        // }

        // Flash message
        session()->flash('success', 'Staff updated successfully!');

        // Redirect to index
        return redirect()->route('admin.staff.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
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
        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.staff.index');
    }
}

