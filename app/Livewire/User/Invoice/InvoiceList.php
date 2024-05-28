<?php

namespace App\Livewire\User\Invoice;

use App\Models\Invoice;
use Illuminate\Support\Facades\Schema;
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

    // Filter Invoice Status
    #[Url()]
    public $filterStatus = 'Unpaid';
    public $invoiceStatuses;

    public function mount()
    {
        $this->invoiceStatuses = Invoice::getStatuses();

        // Invoice Statuses
        $statusUnpaid = Invoice::STATUS_UNPAID;
        $partialPaid = Invoice::STATUS_PARTIALLY_PAID;
        $totalPaid = Invoice::STATUS_PAID;
        $cancelled = Invoice::STATUS_CANCELLED;
    }

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

        // Filter records based on status
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $invoices = $query->where([
            'user_id' => auth()->user()->id,
            // 'is_published' => 1,
        ])
        // ->where('published_on', '<', now())
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $currency = currency(DiligentCreators('currency'));

        return view('livewire.user.invoice.invoice-list', [
            'invoices' => $invoices,
            'currency' => $currency
        ]);
    }
}
