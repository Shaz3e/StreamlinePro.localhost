<?php

namespace App\Livewire\Admin\InvoiceStatus;

use App\Models\InvoiceStatus;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceStatusList extends Component
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
        $query = InvoiceStatus::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('invoice_statuses');

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

        $invoiceStatusList = $query->orderBy('id', 'asc')->paginate($this->perPage);

        return view('livewire.admin.invoice-status.invoice-status-list', [
            'invoiceStatusList' => $invoiceStatusList
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
    public function toggleStatus($invoiceStatusId)
    {
        // Get data
        $invoiceStatus = InvoiceStatus::find($invoiceStatusId);

        // Check user exists
        if (!$invoiceStatus) {
            $this->dispatch('error', 'Invoice Staus not found!');
            return;
        }

        // Change Status
        $invoiceStatus->update(['is_active' => !$invoiceStatus->is_active]);
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
        $invoiceStatus = InvoiceStatus::find($this->recordToDelete);

        // Check record exists
        if (!$invoiceStatus) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $invoiceStatus->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($invoiceStatusId)
    {
        $this->recordToDelete = $invoiceStatusId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        InvoiceStatus::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($invoiceStatusId)
    {
        $this->recordToDelete = $invoiceStatusId;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        InvoiceStatus::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
