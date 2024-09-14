<?php

namespace App\Livewire\Admin\Invoice;

use App\Models\Invoice;
use App\Models\InvoiceLabel;
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

    // Search Invoice by User
    #[Url()]
    public $searchUser = '';

    #[Url()]
    public $users = [];

    // Filter Invoice by Company
    #[Url()]
    public $searchCompany = '';

    #[Url()]
    public $companies = [];

    // Filter Invoice Status
    #[Url()]
    public $filterStatus;
    public $invoiceStatuses;

    // Filter Invoice Label
    #[Url()]
    public $filterLabel;

    // Show deleted records
    public $showDeleted = false;

    public $unpaidInvoices = '';
    public $partialPaidInvoices = '';
    public $totalPaidInvoices = '';
    public $cancelledInvoices = '';

    public $totalUnpaidAmount = '';
    public $totalPaidAmount = '';

    public function mount()
    {
        $this->invoiceStatuses = Invoice::getStatuses();

        // Invoice Statuses
        $statusUnpaid = Invoice::STATUS_UNPAID;
        $partialPaid = Invoice::STATUS_PARTIALLY_PAID;
        $totalPaid = Invoice::STATUS_PAID;
        $cancelled = Invoice::STATUS_CANCELLED;

        // Invoice Count Status
        $this->unpaidInvoices = Invoice::where('status', $statusUnpaid)->count();
        $this->partialPaidInvoices = Invoice::where('status', $partialPaid)->count();
        $this->totalPaidInvoices = Invoice::where('status', $totalPaid)->count();
        $this->cancelledInvoices = Invoice::where('status', $cancelled)->count();

        // Total Amount
        $totalAmount = Invoice::whereNot('status', $cancelled)->sum('total');

        // Total Paid Amount
        $this->totalPaidAmount = Invoice::sum('total_paid');
        // Total Unpaid Amount
        $this->totalUnpaidAmount = $totalAmount - $this->totalPaidAmount;
    }

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

        // Filter records based on user
        if ($this->searchUser !== '') {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->searchUser . '%')
                    ->orWhere('email', 'like', '%' . $this->searchUser . '%');
            });
        }
        // Filter records based on company
        if ($this->searchCompany !== '') {
            $query->whereHas('company', function ($q) {
                $q->where('name', 'like', '%' . $this->searchCompany . '%')
                    ->orWhere('email', 'like', '%' . $this->searchCompany . '%');
            });
        }

        // Filter records based on status
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        // Filter records based on label
        if ($this->filterLabel) {
            $query->where('invoice_label_id', $this->filterLabel);
        }

        // Get all invoices
        $invoices = $query->orderBy('id', 'desc')->paginate($this->perPage);

        $currency = currency(DiligentCreators('currency'));

        // Get all invoice statuses
        $invoiceLabels = InvoiceLabel::where('is_active', 1)->get();

        return view('livewire.admin.invoice.invoice-list', [
            'invoices' => $invoices,
            'currency' => $currency,
            'invoiceLabels' => $invoiceLabels
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
        $this->searchUser = '';
        $this->searchCompany = '';
        $this->filterStatus = '';
        $this->filterLabel = '';
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
