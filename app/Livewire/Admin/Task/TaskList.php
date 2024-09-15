<?php

namespace App\Livewire\Admin\Task;

use App\Models\Admin;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskLabel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TaskList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    #[Url()]
    public $filterLabel;

    #[Url()]
    public $filterStartedTask;

    #[Url()]
    public $filterCompletedTask;

    #[Url()]
    public $filterOverdueTask;

    public $perPage = 10;

    public $id;

    // record to delete
    public $recordToDelete;

    // Show deleted records
    public $showDeleted = false;

    /**
     * Main Blade Render
     */
    public function render()
    {
        // Get logged in admin/staff
        $loggedInStaff = Auth::guard('admin')->user();

        // Check if staff is super admin
        $staff = Admin::find($loggedInStaff->id);

        // Show all records to super admin
        if ($staff->hasRole(['superadmin', 'developer'])) {
            $query = Task::query();
        } else {
            // Show only logged in user tasks
            $query = Task::query()->where('assigned_to', $loggedInStaff->id);
        }

        // Get all columns in the required table
        $columns = Schema::getColumnListing('tasks');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Filter records based on status
        if ($this->filterLabel) {
            $query->where('task_label_id', $this->filterLabel);
        }

        // Filter records based on started/not started
        if ($this->filterStartedTask) {
            $query->where([
                'is_started' => $this->filterStartedTask,
                'is_completed' => 0
            ]);
        }

        // Filter records based on completed/not completed
        if ($this->filterCompletedTask) {
            $query->where('is_completed', $this->filterCompletedTask);
        }

        // Filter records based on overdue task
        if ($this->filterOverdueTask) {
            if ($this->filterOverdueTask == 1) {
                // Show only overdue tasks
                $query->where('due_date', '<', now())
                    ->where('is_completed', 0);
            } elseif ($this->filterOverdueTask == 0) {
                // Hide overdue tasks
                $query->where('due_date', '>', now());
            }
        }


        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $tasks = $query->orderBy('id', 'desc')->paginate($this->perPage);

        // Latest task comment
        $comment = TaskComment::with('postedBy')
            ->latest()
            ->first();

        $taskLabels = TaskLabel::where('is_active', 1)->get();

        return view('livewire.admin.task.task-list', [
            'tasks' => $tasks,
            'taskLabels' => $taskLabels,
            'comment' => $comment,
        ]);
    }

    /**
     * Reset Search
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Update perPage records
     */
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    /**
     * Start Task
     */
    public function startTask($taskId)
    {
        // Get task status data
        $task = Task::find($taskId);

        // Check todo exists
        if (!$task) {
            $this->dispatch('error', 'Selected Task not found!');
            return;
        }

        // Add start_date
        $task->update([
            'start_time' => now(),
            'is_started' => 1,
        ]);

        // Dispatch a success message
        $this->dispatch('taskStarted');
    }

    public function completeTask($taskId)
    {
        // Get task status data
        $task = Task::find($taskId);

        // Check todo exists
        if (!$task) {
            $this->dispatch('error', 'Selected Task not found!');
            return;
        }

        // Add start_date
        $task->update([
            'complete_time' => now(),
            'is_completed' => 1,
        ]);

        // Dispatch a success message
        $this->dispatch('TaskClosed');

        session()->flash('taskClosed');
        return redirect()->route('admin.tasks.show', $taskId);
    }

    /**
     * Confirm Delete
     */
    public function confirmDelete($id)
    {
        $this->recordToDelete = $id;
        $this->dispatch('showDeleteConfirmation');
    }

    /**
     * Delete Record
     */
    #[On('deleteConfirmed')]
    public function delete()
    {
        // Check if a record to delete is set
        if (!$this->recordToDelete) {
            $this->dispatch('error');
            return;
        }

        // get id
        $task = Task::find($this->recordToDelete);

        // Check record exists
        if (!$task) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $task->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($taskId)
    {
        $this->recordToDelete = $taskId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        Task::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($todoId)
    {
        $this->recordToDelete = $todoId;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        Task::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
