<?php

namespace App\Livewire\Admin\Knowledgebase\Article;

use App\Models\Admin;
use App\Models\KnowledgebaseArticle;
use App\Models\KnowledgebaseCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    public $perPage = 10;

    public $id;

    #[Url()]
    public $searchCategory = '';

    // Search Invoice by User
    #[Url()]
    public $searchAuthor = '';

    // record to delete
    public $recordToDelete;

    // Show deleted records
    public $showDeleted = false;

    /**
     * Main Blade Render
     */
    public function render()
    {        // Get logged in admin/staff
        $loggedInStaff = Auth::guard('admin')->user();

        // Check if staff is super admin
        $staff = Admin::find($loggedInStaff->id);

        // Show all records to super admin
        if ($staff->hasRole('superadmin')) {
            $query = KnowledgebaseArticle::query();
        } else {
            // Show only logged in user articles
            $query = KnowledgebaseArticle::query()->where('author_id', $loggedInStaff->id);
        }

        // Get all columns in the required table
        $columns = Schema::getColumnListing('knowledgebase_articles');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Filter records based on category query
        if ($this->searchCategory !== '') {
            $query->whereHas('category', function ($q) {
                $q->where('name', 'like', '%' . $this->searchAuthor . '%')
                    ->where('slug', 'like', '%' . $this->searchAuthor . '%');
            });
        }
        // Filter records based on author query
        if ($this->searchAuthor !== '') {
            $query->whereHas('author', function ($q) {
                $q->where('name', 'like', '%' . $this->searchAuthor . '%')
                    ->orWhere('email', 'like', '%' . $this->searchAuthor . '%');
            });
        }

        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $articles = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.admin.knowledgebase.article.article-list', [
            'articles' => $articles,
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
        $article = KnowledgebaseArticle::find($id);

        // Check user exists
        if (!$article) {
            $this->dispatch('error', 'Knowledgebase Article not found!');
            return;
        }

        // Change Status
        $article->update(['is_published' => !$article->is_published]);
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
        $article = KnowledgebaseArticle::find($this->recordToDelete);

        // Check record exists
        if (!$article) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $article->delete();

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
        KnowledgebaseArticle::withTrashed()->find($this->recordToDelete)->restore();
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

        $article = KnowledgebaseArticle::withTrashed()->find($this->recordToDelete);

        $article->forceDelete();
    }
}
