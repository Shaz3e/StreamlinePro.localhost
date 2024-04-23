<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TodoStatus\StoreTodoStatusRequest;
use App\Models\TodoStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class TodoStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('todo-status.list');

        return view('admin.todo-status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('todo-status.create');
        
        $todoStatusList = TodoStatus::where('is_active', 1)->get();

        return view('admin.todo-status.create', [
            'todoStatusList' => $todoStatusList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoStatusRequest $request)
    {
        // Check Authorize
        Gate::authorize('todo-status.create');

        // Validate data
        $validated = $request->validated();

        // Update record in database
        TodoStatus::create($validated);

        session()->flash('success', 'Todo Status has been created successfully!');

        return redirect()->route('admin.todo-status.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TodoStatus $todoStatus)
    {
        // Check Authorize
        Gate::authorize('todo-status.read');

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
        Gate::authorize('todo-status.update');

        $todoStatusList = TodoStatus::where('is_active', 1)->get();

        return view('admin.todo-status.edit', [
            'todoStatus' => $todoStatus,
            'todoStatusList' => $todoStatusList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTodoStatusRequest $request, TodoStatus $todoStatus)
    {
        // Check Authorize
        Gate::authorize('todo-status.update');

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $todoStatus->update($validated);

        // Flash message
        session()->flash('success', 'Todo Status has been updated successfully!');

        // Redirect to index
        return redirect()->route('admin.todo-status.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('todo-status.read');

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
        Gate::authorize('todo-status.delete');

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.todo-status.index');
    }
}
