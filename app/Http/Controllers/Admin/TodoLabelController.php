<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TodoLabel\StoreTodoLabelRequest;
use App\Models\TodoLabel;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class TodoLabelController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', TodoLabel::class);

        return view('admin.todo-label.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', TodoLabel::class);

        return view('admin.todo-label.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoLabelRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', TodoLabel::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $todoLabel = TodoLabel::create($validated);

        session()->flash('success', 'Todo Label has been created successfully!');
        
        return $this->saveAndRedirect($request, 'todo-labels', $todoLabel->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(TodoLabel $todoLabel)
    {
        // Check Authorize
        Gate::authorize('view', $todoLabel);

        $audits = $todoLabel->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.todo-label.show', [
            'todoLabel' => $todoLabel,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TodoLabel $todoLabel)
    {
        // Check Authorize
        Gate::authorize('update', $todoLabel);

        return view('admin.todo-label.edit', [
            'todoLabel' => $todoLabel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTodoLabelRequest $request, TodoLabel $todoLabel)
    {
        // Check Authorize
        Gate::authorize('view', $todoLabel);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $todoLabel->update($validated);

        // Flash message
        session()->flash('success', 'Todo Label has been updated successfully!');
        
        return $this->saveAndRedirect($request, 'todo-labels', $todoLabel->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', TodoLabel::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.todo-label.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.todo-labels.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {        
        // Check Authorize
        Gate::authorize('delete', TodoLabel::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.todo-labels.index');
    }
}
