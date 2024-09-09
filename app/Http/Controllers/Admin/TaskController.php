<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Task\StoreTaskRequest;
use App\Models\Admin;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskLabel;
use App\Trait\Admin\FormHelper;
use App\Trait\Admin\SmsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class TaskController extends Controller
{
    use FormHelper;
    use SmsTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', Task::class);

        return view('admin.task.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { // Check Authorize
        Gate::authorize('create', Task::class);

        // Get all active task list
        $taskLabels = TaskLabel::where('is_active', 1)->get();

        return view('admin.task.create', [
            'taskLabels' => $taskLabels,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', Task::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $task = Task::create($validated);

        // Send SMS
        // $this->sendSms($task->assignee->mobile,$task->title);

        session()->flash('success', 'The Task has been created successfully!');

        return $this->saveAndRedirect($request, 'tasks', $task->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Check Authorize
        Gate::authorize('view', $task);

        // Start Task
        if (!is_null(request()->start) && request()->start == 1 && $task->is_started == 0) {
            $task->is_started = 1;
            $task->start_time = now();
            $task->save();
            return back()->with('success', 'The Task has been started successfully!');
        }

        // Complete Task
        if (!is_null(request()->complete) && request()->complete == 1 && $task->is_completed == 0) {
            $task->is_completed = 1;
            $task->complete_time = now();
            $task->save();
            return back()->with('success', 'The Task has been completed successfully!');
        }

        $taskLabels = TaskLabel::where('is_active', 1)->get();

        $taskComments = TaskComment::where('task_id', $task->id)
            ->orderBy('id', 'asc')
            ->get();

        $audits = $task->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.task.show', [
            'task' => $task,
            'taskLabels' => $taskLabels,
            'taskComments' => $taskComments,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // Check Authorize
        Gate::authorize('update', $task);

        // Get all active task list
        $taskLabels = TaskLabel::where('is_active', 1)->get();

        return view('admin.task.edit', [
            'task' => $task,
            'taskLabels' => $taskLabels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        // Check Authorize
        Gate::authorize('update', $task);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $task->update($validated);

        // Flash message
        session()->flash('success', 'The Task has been updated successfully!');

        return $this->saveAndRedirect($request, 'tasks', $task->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', Task::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.task.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.tasks.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('delete', Task::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.tasks.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $task = Task::find($id);
        $task->task_label_id = $request->task_label_id;
        $task->save();
        return response()->json(['message' => 'Status updated successfully']);
    }

    /**
     * Comment on Task
     */
    public function comment(Request $request, Task $taskId)
    {
        // Check Authorize
        Gate::authorize('view', $taskId);

        $validated = $request->validate([
            'message' => 'required|min:10',
            'attachments' => [
                'nullable',
                'array',
                'validate_each:mimes:jpeg,png',
                'max:2048',
            ],
        ]);

        // Add comment
        $comment = new TaskComment();
        $comment->task_id = $taskId->id;
        $comment->message = $validated['message'];
        $comment->posted_by = Auth::user()->id;

        // Retrieve all the uploaded images from the session variable
        $uploadedAttachments = session()->get('uploaded_attachments');

        if (!empty($uploadedAttachments)) {
            $validated['attachments'] = json_encode($uploadedAttachments);
            $comment->attachments = implode(',', $uploadedAttachments);
        }

        $comment->save();

        session()->flash('success', 'Your comment has been updated!');

        // Clear the uploaded_attachments session variable
        session()->forget('uploaded_attachments');

        return $this->saveAndRedirect($request, 'tasks', $taskId->id);
    }

    /**
     * Upload attachments
     */
    public function uploadAttachments(Request $request)
    {
        // Get the uploaded image
        $image = $request->file('attachments');

        // File Name
        $filename = rand(1, 9999) . '-' . time() . '.' . $image->extension();

        // Store the uploaded image in a session variable
        session()->push('uploaded_attachments', $image->storeAs('tasks/attachments', $filename, 'public'));

        return response()->json(['message' => 'Image uploaded successfully!']);
    }
}
