<?php

namespace App\Livewire\Admin\Task;

use App\Models\Admin;
use App\Models\Task;
use App\Models\TaskStatus;
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
    public $filterStatus;

    public $perPage = 10;

    public $id;

    // Update todo status
    public $statuses = [];

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
        if ($staff->hasRole('superadmin')) {
            $query = Task::query();
        } else {
            // Show only logged in user tasks
            $query = Task::query()->where('assigned_to', $loggedInStaff->id);
        }

        // Get all columns in the required table
        $columns = Schema::getColumnListing('todos');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Filter records based on status
        if ($this->filterStatus) {
            $query->where('task_status_id', $this->filterStatus);
        }


        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $tasks = $query->orderBy('id', 'desc')->paginate($this->perPage);

        $taskStatusList = TaskStatus::where('is_active', 1)->get();

        return view('livewire.admin.task.task-list', [
            'tasks' => $tasks,
            'taskStatusList' => $taskStatusList,
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
            'start_date' => now(),
            'task_status_id' => 2,
        ]);

        // Dispatch a success message
        session()->flash('success', 'Task has been started now!');
    }

    /**
     * Toggle Status
     */
    public function updateStatus($taskId)
    {
        // Get data
        $todo = Task::find($taskId);

        // Check user exists
        if (!$todo) {
            $this->dispatch('error', 'Todo not found!');
            return;
        }
        // Change Status
        $todo->update([
            'todo_status_id' => $this->statuses[$taskId . '_status'],
        ]);

        $this->dispatch('statusChanged');
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
