<?php

namespace App\Livewire\Admin\TodoStatus;

use App\Models\TodoStatus;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TodoStatusList extends Component
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
        $query = TodoStatus::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('todo_statuses');

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

        $todoStatusList = $query->orderBy('id', 'asc')->paginate($this->perPage);

        return view('livewire.admin.todo-status.todo-status-list', [
            'todoStatusList' => $todoStatusList
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
    public function toggleStatus($todoStatusId)
    {
        // Get data
        $todoStatus = TodoStatus::find($todoStatusId);

        // Check user exists
        if (!$todoStatus) {
            $this->dispatch('error', 'Todo Staus not found!');
            return;
        }

        // Change Status
        $todoStatus->update(['is_active' => !$todoStatus->is_active]);
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
        $todoStatus = TodoStatus::find($this->recordToDelete);

        // Check record exists
        if (!$todoStatus) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $todoStatus->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($todoStatusId)
    {
        $this->recordToDelete = $todoStatusId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        TodoStatus::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($userId)
    {
        $this->recordToDelete = $userId;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        TodoStatus::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}