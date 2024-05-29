<?php

namespace App\Livewire\Admin\ProductService;

use App\Models\ProductService;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductServiceList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    public $perPage = 10;

    public $id;

    // Filter by Product or Services
    public $filterProductService;

    // record to delete
    public $recordToDelete;

    // Show deleted records
    public $showDeleted = false;

    /**
     * Main Blade Render
     */
    public function render()
    {
        $query = ProductService::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('products_and_services');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Filter by Product or Services
        if ($this->filterProductService) {
            $query->where('type', $this->filterProductService);
        }

        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $productsServices = $query->orderBy('id', 'asc')->paginate($this->perPage);

        return view('livewire.admin.product-service.product-service-list', [
            'productsServices' => $productsServices
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
        $productService = ProductService::find($id);

        // Check user exists
        if (!$productService) {
            $this->dispatch('error', 'Product or Service not found!');
            return;
        }

        // Change Status
        $productService->update(['is_active' => !$productService->is_active]);
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
        $productService = ProductService::find($this->recordToDelete);

        // Check record exists
        if (!$productService) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $productService->delete();

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
        ProductService::withTrashed()->find($this->recordToDelete)->restore();
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

        $productService = ProductService::withTrashed()->find($this->recordToDelete);

        $productService->forceDelete();
    }
}
