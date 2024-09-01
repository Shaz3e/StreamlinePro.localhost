<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

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

        if (!$invoice) {
            return redirect()->route('invoice.index')->with('error', 'Invoice not found');
        }

        // Check the status parameter
        // Check the status parameter
        if ($request->has('status') && $request->input('status') == 'success') {
            // Setup Stripe
            Stripe::setApiKey(config('stripe.secret_key'));

            // Retrieve the session ID from the request (if applicable)
            $sessionId = $request->input('session_id');

            if ($sessionId) {
                try {
                    // Retrieve the session details from Stripe
                    $session = StripeSession::retrieve($sessionId);

                    if ($session && $session->payment_status === 'paid') {
                        // Create new payment instance and save
                        $payment = new Payment();
                        $payment->transaction_number = $session->payment_intent;
                        $payment->invoice_id = $invoice->id;
                        $payment->transaction_date = now();
                        $payment->amount = $session->amount_total / 100; // Stripe stores amounts in cents
                        $payment->payment_method = "Stripe";
                        $payment->save();

                        // Update the invoice total_paid
                        $invoice->total_paid += $payment->amount;
                        $invoice->save();

                        session()->flash('status', 'Payment was successful!');
                    } else {
                        session()->flash('status', 'Payment was not completed.');
                    }
                } catch (\Exception $e) {
                    session()->flash('status', 'There was an error processing the payment.');
                }
            } else {
                session()->flash('status', 'No session ID provided.');
            }
        } elseif ($request->has('status') && $request->input('status') == 'cancel') {
            session()->flash('status', 'Payment was cancelled.');
        }

        // Get currency
        $currency = currency(DiligentCreators('currency'));

        // Get invoice items
        $items = InvoiceItem::where('invoice_id', $invoice->id)->get();

        // Get all transactions related to this invoice
        $payments = Payment::where('invoice_id', $invoice->id)->get();

        return view('user.invoice.show', [
            'invoice' => $invoice,
            'currency' => $currency,
            'items' => $items,
            'payments' => $payments,
        ]);
    }
}
