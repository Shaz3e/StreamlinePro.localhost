<?php

namespace App\Livewire\Admin\Todo;

use App\Models\Todo;
use App\Models\TodoStatus;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    #[Url()]
    public $filterStatus;

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
        $query = Todo::query()->where('admin_id', auth()->user()->id);

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
            $query->where('todo_status_id', $this->filterStatus);
        }


        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $todos = $query->orderBy('id', 'desc')->paginate($this->perPage);

        $getTodoStatus = TodoStatus::all();

        return view('livewire.admin.todo.todo-list', [
            'todos' => $todos,
            'getTodoStatus' => $getTodoStatus,
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
    public function toggleStatus($todoId)
    {
        // Get data
        $todo = Todo::find($todoId);

        // Check user exists
        if (!$todo) {
            $this->dispatch('error', 'Todo not found!');
            return;
        }

        // Change Status
        $todo->update(['is_active' => !$todo->is_active]);
        
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
        $todo = Todo::find($this->recordToDelete);

        // Check record exists
        if (!$todo) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $todo->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($todoId)
    {
        $this->recordToDelete = $todoId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        Todo::withTrashed()->find($this->recordToDelete)->restore();
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
        Todo::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
