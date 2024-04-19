<?php

namespace App\Livewire\Admin\Company;

use App\Models\Company;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyList extends Component
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
        $query = Company::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('companies');

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

        $companies = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.admin.company.company-list', [
            'companies' => $companies
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
    public function toggleStatus($companyId)
    {
        // Get data
        $company = Company::find($companyId);

        // Check user exists
        if (!$company) {
            $this->dispatch('error', 'User not found!');
            return;
        }

        // Change Status
        $company->update(['is_active' => !$company->is_active]);
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
        $company = Company::find($this->recordToDelete);

        // Check record exists
        if (!$company) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $company->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($companyId)
    {
        $this->recordToDelete = $companyId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        Company::withTrashed()->find($this->recordToDelete)->restore();
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
        Company::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
