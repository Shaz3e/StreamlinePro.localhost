<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Todo\StoreTodoRequest;
use App\Models\Todo;
use App\Models\TodoLabel;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class TodoController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', Todo::class);

        return view('admin.todo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', Todo::class);

        $todoLabels = TodoLabel::where('is_active', 1)->get();

        return view('admin.todo.create', [
            'todoLabels' => $todoLabels,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', Todo::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $todo = Todo::create($validated);
        $todo->admin_id = auth()->user()->id;
        $todo->save();

        session()->flash('success', 'Your Todo has been created successfully!');

        return $this->saveAndRedirect($request, 'todos', $todo->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        // Check Authorize
        Gate::authorize('view', $todo);

        // Close Todo
        if(request()->has('close') == 1){
            $todo->is_closed = 1;
            $todo->closed_at = now();
            $todo->save();
            session()->flash('success', 'Your TODO has been closed successfully!');
            return back();
        }


        $audits = $todo->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.todo.show', [
            'todo' => $todo,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        // Check Authorize
        Gate::authorize('update', $todo);

        $todoLabels = TodoLabel::where('is_active', 1)->get();

        return view('admin.todo.edit', [
            'todo' => $todo,
            'todoLabels' => $todoLabels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTodoRequest $request, Todo $todo)
    {
        // Check Authorize
        Gate::authorize('update', $todo);

        // Validate data
        $validated = $request->validated();
        
        // Check if todo was previously closed
        if ($todo->is_closed) {
            // Reopen todo
            $validated['is_closed'] = 0;
            $validated['closed_at'] = null;
        }

        // Update record in database
        $todo->update($validated);

        // Flash message
        session()->flash('success', 'Your TODO has been updated successfully!');

        return $this->saveAndRedirect($request, 'todos', $todo->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', Todo::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.todo.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.todos.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('delete', Todo::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.todos.index');
    }
}
