<?php

namespace App\Livewire\Admin\TaskLabel;

use App\Models\TaskLabel;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TaskLabelList extends Component
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
        $query = TaskLabel::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('task_labels');

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

        $taskLabels = $query->orderBy('id', 'asc')->paginate($this->perPage);

        return view('livewire.admin.task-label.task-label-list', [
            'taskLabels' => $taskLabels
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
    public function toggleStatus($id)
    {
        // Get data
        $taskLabel = TaskLabel::find($id);

        // Check user exists
        if (!$taskLabel) {
            $this->dispatch('error', 'Task Label not found!');
            return;
        }

        // Change Status
        $taskLabel->update(['is_active' => !$taskLabel->is_active]);
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
        $taskLabel = TaskLabel::find($this->recordToDelete);

        // Check record exists
        if (!$taskLabel) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $taskLabel->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($id)
    {
        $this->recordToDelete = $id;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        TaskLabel::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($id)
    {
        $this->recordToDelete = $id;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        TaskLabel::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}