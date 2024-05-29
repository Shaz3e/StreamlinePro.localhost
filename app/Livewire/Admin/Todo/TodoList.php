<?php

namespace App\Livewire\Admin\Todo;

use App\Models\Todo;
use App\Models\TodoLabel;
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
    public $filterLabel;

    public $perPage = 10;

    public $id;

    // Update todo status
    public $labels = [];

    // record to delete
    public $recordToDelete;

    // Show deleted records
    public $showDeleted = false;

    /**
     * Main Blade Render
     */
    public function render()
    {
        $query = Todo::query()
            ->where('admin_id', auth()->user()->id)
            ->where('is_closed', 0);

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
        if ($this->filterLabel) {
            $query->where('todo_label_id', $this->filterLabel);
        }

        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $todos = $query->orderBy('id', 'desc')->paginate($this->perPage);

        $getTodoLabels = TodoLabel::where('is_active', 1)->get();

        return view('livewire.admin.todo.todo-list', [
            'todos' => $todos,
            'getTodoLabels' => $getTodoLabels,
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
    public function updateLabel($todoId)
    {
        // Get data
        $todo = Todo::find($todoId);

        // Check todo exists
        if (!$todo) {
            $this->dispatch('error', 'Todo not found!');
            return;
        }
        // Change Status
        $todo->update([
            'todo_label_id' => $this->labels[$todoId . '_label'],
        ]);

        $this->dispatch('statusChanged');
    }

    /**
     * Close todo
     */
    public function closeTodo($todoId)
    {
        // Get data
        $todo = Todo::find($todoId);

        // Check todo exists
        if (!$todo) {
            $this->dispatch('error', 'Todo not found!');
            return;
        }

        // Close todo
        $todo->update([
            'is_closed' => 1,
            'closed_at' => now(),
        ]);

        $this->dispatch('todoClosed');
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
