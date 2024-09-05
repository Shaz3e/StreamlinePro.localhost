<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Invoice;
use Livewire\Component;

class InvoiceSummary extends Component
{
    public function render()
    {
        $currency = currency(DiligentCreators('currency'));

        $unpaid = Invoice::STATUS_UNPAID;
        $partialPaid = Invoice::STATUS_PARTIALLY_PAID;

        $unpaidInvoices = Invoice::where('status', $unpaid)->count();
        $partialPaidInvoices = Invoice::where('status', $partialPaid)->count();

        $totalAmount = Invoice::sum('total');
        $totalPaidAmount = Invoice::sum('total_paid');

        $unpaidInvoiceAmount = $totalAmount - $totalPaidAmount;


        $partialPaidInvoiceAmount = Invoice::where('status', $partialPaid)->sum('total_paid');

        return view('livewire.admin.dashboard.invoice-summary', [
            'currency' => $currency,
            'unpaidInvoices' => $unpaidInvoices,
            'unpaidInvoiceAmount' => $unpaidInvoiceAmount,
            'partialPaidInvoices' => $partialPaidInvoices,
            'partialPaidInvoiceAmount' => $partialPaidInvoiceAmount,
        ]);
    }
}
