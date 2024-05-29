<?php

namespace App\Livewire\Admin\Knowledgebase\Category;

use App\Models\KnowledgebaseCategory;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
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
        $query = KnowledgebaseCategory::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('knowledgebase_categories');

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

        $categories = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.admin.knowledgebase.category.category-list',[
            'categories' => $categories
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
        $category = KnowledgebaseCategory::find($id);

        // Check user exists
        if (!$category) {
            $this->dispatch('error', 'Knowledgebase Category not found!');
            return;
        }

        // Change Status
        $category->update(['is_active' => !$category->is_active]);
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
        $category = KnowledgebaseCategory::find($this->recordToDelete);

        // Check record exists
        if (!$category) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $category->delete();

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
        KnowledgebaseCategory::withTrashed()->find($this->recordToDelete)->restore();
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
        // Check if a record to delete is set delete image
        if (!$this->recordToDelete) {
            $this->dispatch('error');
            return;
        }

        $category = KnowledgebaseCategory::withTrashed()->find($this->recordToDelete);

        $category->forceDelete();
    }
}

