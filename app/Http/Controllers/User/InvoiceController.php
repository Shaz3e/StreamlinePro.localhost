<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('user.invoice.index');
    }

    public function show(Request $request, Invoice $invoice)
    {
        $invoice = Invoice::where([
            'user_id' => auth()->user()->id,
            'id' => $request->id
        ])
            ->first();

        if(!$invoice){
            return redirect()->route('invoice.index')->with('error', 'Invoice is not exists');
        }

        // Get invoice items
        $items = InvoiceItem::where('invoice_id', $invoice->id)->get();

        // Get all transactions related to this invoice
        $payments = Payment::where('invoice_id', $invoice->id)->get();

        return view('user.invoice.show', [
            'invoice' => $invoice,
            'items' => $items,
            'payments' => $payments,
        ]);
    }
}
