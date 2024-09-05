<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Invoice;
use Livewire\Component;

class RecentInvoice extends Component
{
    public function render()
    {
        $currency = currency(DiligentCreators('currency'));

        $invoices = Invoice::latest()->take(5)->get();
        return view('livewire.admin.dashboard.recent-invoice', [
            'currency' => $currency,
            'invoices' => $invoices
        ]);
    }
}
