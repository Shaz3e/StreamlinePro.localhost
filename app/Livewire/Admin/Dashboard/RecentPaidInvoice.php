<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Invoice;
use Livewire\Component;

class RecentPaidInvoice extends Component
{
    public function render()
    {
        $paid = Invoice::STATUS_PAID;
        $invoices = Invoice::latest()->take(5)->where('status', $paid)->get();
        return view('livewire.admin.dashboard.recent-paid-invoice',[
            'invoices' => $invoices
        ]);
    }
}
