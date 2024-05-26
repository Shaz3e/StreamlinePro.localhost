<?php

namespace App\Livewire\Admin\Promotion;

use App\Models\Promotion;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PromotionList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    public $perPage = 10;

    public $id;

    // record to delete
    public $recordToDelete;

    // Show active Promotions
    public $showActive = false;

    // Show featured promotions
    public $showFeatured = false;

    // Show deleted records
    public $showDeleted = false;

    /**
     * Main Blade Render
     */
    public function render()
    {
        $query = Promotion::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('promotions');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Apply filter for active records if the option is selected
        if ($this->showActive) {
            $query->where('is_active', 1);
        }

        // Apply filter for featured records
        if($this->showFeatured){
            $query->where('is_featured', 1);
        }

        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $promotions = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.admin.promotion.promotion-list', [
            'promotions' => $promotions
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
    public function toggleStatus($promotionId)
    {
        // Get data
        $promotion = Promotion::find($promotionId);

        // Check user exists
        if (!$promotion) {
            $this->dispatch('error', 'Promotion not found!');
            return;
        }

        // Change Status
        $promotion->update(['is_active' => !$promotion->is_active]);
        $this->dispatch('statusChanged');
    }

    /**
     * Toggle Featured
     */
    public function toggleFeatured($promotionId)
    {
        // Get data
        $promotion = Promotion::find($promotionId);

        // Check user exists
        if (!$promotion) {
            $this->dispatch('error', 'Promotion not found!');
            return;
        }

        // Change Status
        $promotion->update(['is_featured' => !$promotion->is_featured]);
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
        $promotion = Promotion::find($this->recordToDelete);

        // Check record exists
        if (!$promotion) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $promotion->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($promotionId)
    {
        $this->recordToDelete = $promotionId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        Promotion::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($promotionId)
    {
        $this->recordToDelete = $promotionId;
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

        $promotion = Promotion::withTrashed()->find($this->recordToDelete);

        File::delete('storage/' . $promotion->image);
        $promotion->forceDelete();
    }
}

