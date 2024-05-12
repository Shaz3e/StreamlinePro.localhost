<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Invoice;
use Livewire\Component;

class RecentInvoice extends Component
{
    public function render()
    {
        $invoices = Invoice::latest()->take(5)->get();
        return view('livewire.admin.dashboard.recent-invoice',[
            'invoices' => $invoices
        ]);
    }
}
