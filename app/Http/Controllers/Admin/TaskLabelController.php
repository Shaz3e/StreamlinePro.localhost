<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaskLabel\StoreTaskLabelRequest;
use App\Models\TaskLabel;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class TaskLabelController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', TaskLabel::class);

        return view('admin.task-label.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', TaskLabel::class);

        return view('admin.task-label.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskLabelRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', TaskLabel::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $taskLabel = TaskLabel::create($validated);

        session()->flash('success', 'Task Label has been created successfully!');
        
        return $this->saveAndRedirect($request, 'task-labels', $taskLabel->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskLabel $taskLabel)
    {
        // Check Authorize
        Gate::authorize('view', $taskLabel);

        $audits = $taskLabel->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.task-label.show', [
            'taskLabel' => $taskLabel,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskLabel $taskLabel)
    {
        // Check Authorize
        Gate::authorize('update', $taskLabel);

        return view('admin.task-label.edit', [
            'taskLabel' => $taskLabel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskLabelRequest $request, TaskLabel $taskLabel)
    {
        // Check Authorize
        Gate::authorize('update', $taskLabel);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $taskLabel->update($validated);

        // Flash message
        session()->flash('success', 'Task Label has been updated successfully!');
        
        return $this->saveAndRedirect($request, 'task-labels', $taskLabel->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', TaskLabel::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.task-label.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.task-labels.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {        
        // Check Authorize
        Gate::authorize('delete', TaskLabel::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.task-labels.index');
    }
}
