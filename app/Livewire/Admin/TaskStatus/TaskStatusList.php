<?php

namespace App\Livewire\Admin\TaskStatus;

use App\Models\TaskStatus;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TaskStatusList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

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
        $query = TaskStatus::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('task_statuses');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $taskStatusList = $query->orderBy('id', 'asc')->paginate($this->perPage);

        return view('livewire.admin.task-status.task-status-list', [
            'taskStatusList' => $taskStatusList
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
     * Toggle Status
     */
    public function toggleStatus($taskStatusId)
    {
        // Get data
        $taskStatus = TaskStatus::find($taskStatusId);

        // Check user exists
        if (!$taskStatus) {
            $this->dispatch('error', 'Task Staus not found!');
            return;
        }

        // Change Status
        $taskStatus->update(['is_active' => !$taskStatus->is_active]);
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
        $taskStatus = TaskStatus::find($this->recordToDelete);

        // Check record exists
        if (!$taskStatus) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $taskStatus->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($taskStatusId)
    {
        $this->recordToDelete = $taskStatusId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        TaskStatus::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($taskStatusId)
    {
        $this->recordToDelete = $taskStatusId;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        TaskStatus::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}