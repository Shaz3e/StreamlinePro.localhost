<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Department\StoreDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('company.list');

        return view('admin.department.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('company.create');
        
        return view('admin.department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        // Check Authorize
        Gate::authorize('department.create');
        
        // Validate data
        $validated = $request->validated();

        // Update record in database
        Department::create($validated);


        session()->flash('success', 'Department created successfully!');

        return redirect()->route('admin.departments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        // Check Authorize
        Gate::authorize('department.read');
        
        $audits = $department->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.department.show', [
            'department' => $department,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        // Check Authorize
        Gate::authorize('department.update');

        return view('admin.department.edit', [
            'department' => $department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDepartmentRequest $request, Department $department)
    {
        // Check Authorize
        Gate::authorize('department.update');
        
        // Validate data
        $validated = $request->validated();

        // Update record in database
        $department->update($validated);

        // Flash message
        session()->flash('success', 'Department updated successfully!');

        // Redirect to index
        return redirect()->route('admin.departments.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('department.read');
        
        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.department.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.departments.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('department.delete');

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.departments.index');
    }
}
