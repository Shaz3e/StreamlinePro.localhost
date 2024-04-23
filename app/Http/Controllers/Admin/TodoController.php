<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Todo\StoreTodoRequest;
use App\Models\Todo;
use App\Models\TodoStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.todo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $todoStatus = TodoStatus::where('is_active', 1)->get();

        return view('admin.todo.create', [
            'todoStatus' => $todoStatus,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        // Validate data
        $validated = $request->validated();

        // Update record in database
        $todo = Todo::create($validated);
        $todo->admin_id = auth()->user()->id;
        $todo->save();

        session()->flash('success', 'Your Todo has been created successfully!');

        return redirect()->route('admin.todos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
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
        $todoStatus = TodoStatus::where('is_active', 1)->get();

        return view('admin.todo.edit', [
            'todo' => $todo,
            'todoStatus' => $todoStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTodoRequest $request, Todo $todo)
    {
        // Validate data
        $validated = $request->validated();

        // Update record in database
        $todo->update($validated);

        // Flash message
        session()->flash('success', 'Your TODO has been updated successfully!');

        // Redirect to index
        return redirect()->route('admin.todos.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
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
        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.todos.index');
    }
}
