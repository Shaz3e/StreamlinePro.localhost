<?php

namespace App\Http\Controllers\User\PaymentMethods\Stripe;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StripeController extends Controller
{
    public function processPayment(Request $request)
    {
        // Validate and process the payment
        $request->validate([
            'amount' => 'required|numeric|min:0.50',
            'stripeToken' => 'required',
        ]);

        $invoice = Invoice::find($request->invoice);

        // Convert amount cents
        $amountInCents = $request->amount * 100;

        // Example for Stripe:
        \Stripe\Stripe::setApiKey(config('stripe.secret_key'));

        try {
            $charge = \Stripe\Charge::create([
                'amount' => $amountInCents,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment for invoice# ' . $invoice->id . ' from Customer ' . $invoice->user->name,
                'metadata' => [
                    'invoice_details' => 'Invoice ID: ' . $invoice->id,
                    'amount' => $request->amount,
                ],
            ]);

            // Save payment details to the database
            $payment = new Payment();
            $payment->transaction_number = Str::uuid();
            $payment->invoice_id = $invoice->id;
            $payment->transaction_date = now();
            $payment->amount = $request->amount;
            $payment->payment_method = 'Stripe';
            $payment->save();

            return response()->json(['success' => 'Payment successful!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
