<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TodoStatus\StoreTodoStatusRequest;
use App\Models\TodoStatus;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class TodoStatusController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', TodoStatus::class);

        return view('admin.todo-status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', TodoStatus::class);

        return view('admin.todo-status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoStatusRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', TodoStatus::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $todoStatus = TodoStatus::create($validated);

        session()->flash('success', 'Todo Status has been created successfully!');
        
        return $this->saveAndRedirect($request, 'todo-status', $todoStatus->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(TodoStatus $todoStatus)
    {
        // Check Authorize
        Gate::authorize('view', $todoStatus);

        $audits = $todoStatus->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.todo-status.show', [
            'todoStatus' => $todoStatus,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TodoStatus $todoStatus)
    {
        // Check Authorize
        Gate::authorize('update', $todoStatus);

        return view('admin.todo-status.edit', [
            'todoStatus' => $todoStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTodoStatusRequest $request, TodoStatus $todoStatus)
    {
        // Check Authorize
        Gate::authorize('view', $todoStatus);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $todoStatus->update($validated);

        // Flash message
        session()->flash('success', 'Todo Status has been updated successfully!');
        
        return $this->saveAndRedirect($request, 'todo-status', $todoStatus->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', TodoStatus::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.todo-status.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.todo-status.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {        
        // Check Authorize
        Gate::authorize('delete', TodoStatus::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.todo-status.index');
    }
}
