<?php

namespace App\Livewire\Admin\Invoice;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceStatus;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    public $perPage = 10;

    public $id;

    // record to delete
    public $recordToDelete;

    // Filter Invoice by Company
    #[Url()]
    public $filterCompany;

    // Filter Invoice Status
    #[Url()]
    public $filterStatus;

    // Show deleted records
    public $showDeleted = false;

    /**
     * Main Blade Render
     */
    public function render()
    {
        $query = Invoice::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('invoices');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Filter records based on company
        if ($this->filterCompany) {
            $query->where('company_id', $this->filterCompany);
        }

        // Filter records based on status
        if ($this->filterStatus) {
            $query->where('invoice_status_id', $this->filterStatus);
        }

        // Get all invoices
        $invoices = $query->orderBy('id', 'desc')->paginate($this->perPage);

        // Get all companies
        $companies = Company::where('is_active', 1)->get();

        // Get all invoice statuses
        $invoiceStatus = InvoiceStatus::where('is_active', 1)->get();

        return view('livewire.admin.invoice.invoice-list', [
            'invoices' => $invoices,
            'companies' => $companies,
            'invoiceStatus' => $invoiceStatus
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
     * Reset Filters
     */
    public function resetFilters()
    {
        $this->search = '';
        $this->filterCompany = '';
        $this->filterStatus = '';
        $this->showDeleted = '';
        $this->resetPage();
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
        $invoice = Invoice::find($this->recordToDelete);

        // Check record exists
        if (!$invoice) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $invoice->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($invoiceId)
    {
        $this->recordToDelete = $invoiceId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        Invoice::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($invoiceId)
    {
        $this->recordToDelete = $invoiceId;
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

        $invoice = Invoice::withTrashed()->find($this->recordToDelete);

        $invoice->forceDelete();
    }
}
