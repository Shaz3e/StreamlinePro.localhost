<?php

namespace App\Livewire\Admin\InvoiceLabel;

use App\Models\InvoiceLabel;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceLabelList extends Component
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
        $query = InvoiceLabel::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('invoice_labels');

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

        $invoiceLabelList = $query->orderBy('id', 'asc')->paginate($this->perPage);

        return view('livewire.admin.invoice-label.invoice-label-list', [
            'invoiceLabelList' => $invoiceLabelList
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
        $invoiceLabel = InvoiceLabel::find($id);

        // Check user exists
        if (!$invoiceLabel) {
            $this->dispatch('error', 'Invoice Staus not found!');
            return;
        }

        // Change Status
        $invoiceLabel->update(['is_active' => !$invoiceLabel->is_active]);
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
        $invoiceLabel = InvoiceLabel::find($this->recordToDelete);

        // Check record exists
        if (!$invoiceLabel) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $invoiceLabel->delete();

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
        InvoiceLabel::withTrashed()->find($this->recordToDelete)->restore();
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
        InvoiceLabel::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
