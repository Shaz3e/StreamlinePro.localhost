<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaskStatus\StoreTaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;
use Symfony\Component\CssSelector\Node\FunctionNode;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('task-status.list');

        return view('admin.task-status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('task-status.create');

        return view('admin.task-status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskStatusRequest $request)
    {
        // Check Authorize
        Gate::authorize('task-status.create');

        // Validate data
        $validated = $request->validated();

        // Update record in database
        TaskStatus::create($validated);

        session()->flash('success', 'Task Status has been created successfully!');

        return redirect()->route('admin.task-status.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $taskStatus)
    {
        // Check Authorize
        Gate::authorize('task-status.read');

        $audits = $taskStatus->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.task-status.show', [
            'taskStatus' => $taskStatus,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        // Check Authorize
        Gate::authorize('task-status.update');

        return view('admin.task-status.edit', [
            'taskStatus' => $taskStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        // Check Authorize
        Gate::authorize('task-status.update');

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $taskStatus->update($validated);

        // Flash message
        session()->flash('success', 'Task Status has been updated successfully!');

        // Redirect to index
        return redirect()->route('admin.task-status.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('task-status.read');

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.task-status.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.task-status.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {        
        // Check Authorize
        Gate::authorize('task-status.delete');

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.task-status.index');
    }
}
