<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Invoice;
use Livewire\Component;

class InvoiceSummary extends Component
{
    public function render()
    {
        $unpaid = Invoice::STATUS_UNPAID;
        $unpaidInvoices = Invoice::where('status', $unpaid)->count();
        $unpaidInvoiceAmount = Invoice::where('status', $unpaid)->sum('total');
        $partialPaid = Invoice::STATUS_PARTIALLY_PAID;
        $partialPaidInvoices = Invoice::where('status', $partialPaid)->count();
        $partialPaidInvoiceAmount = Invoice::where('status', $partialPaid)->sum('total');

        return view('livewire.admin.dashboard.invoice-summary',[
            'unpaidInvoices' => $unpaidInvoices,
            'unpaidInvoiceAmount' => $unpaidInvoiceAmount,
            'partialPaidInvoices' => $partialPaidInvoices,
            'partialPaidInvoiceAmount' => $partialPaidInvoiceAmount,
        ]);
    }
}
