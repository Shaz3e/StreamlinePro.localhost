<?php

namespace App\Http\Controllers\User\PaymentMethods\Stripe;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function processPayment(Request $request)
    {
        $invoice = Invoice::find($request->invoice_id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        // Get max amount
        $maxAmount = $invoice->total - $invoice->total_paid;

        // Validate and process the payment
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.50|max:' . $maxAmount,
            'payment_method' => 'required',
        ]);

        // Convert amount to cents
        $amountInCents = $validatedData['amount'] * 100;


        // Set the Stripe API key
        Stripe::setApiKey(config('stripe.secret_key'));

        try {
            // Create or retrieve customer
            $customer = Customer::create([
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ]);

            // Create a PaymentIntent with the order amount and currency
            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'usd',
                'customer' => $customer->id,
                'payment_method' => $validatedData['payment_method'],
                // 'confirmation_method' => 'manual',
                'confirm' => true,
                // 'return_url' => route('payment-method.stripe.payment.callback'), // Add this line
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
                'description' => 'Payment for invoice# ' . $invoice->id . ' from Customer ' . $invoice->user->name,
                'metadata' => [
                    'invoice_id' => $invoice->id,
                    'amount' => $validatedData['amount'],
                ],
            ]);

            // Return the client secret to the client
            return response()->json(['client_secret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function handlePaymentConfirmation(Request $request)
    {
        $paymentIntentId = $request->input('payment_intent_id');

        Stripe::setApiKey(config('stripe.secret_key'));

        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status === 'succeeded') {
                // Create new payment instance and save
                $payment = new Payment();
                $payment->transaction_number = $paymentIntent->id;
                $payment->invoice_id = $paymentIntent->metadata->invoice_id;
                $payment->transaction_date = now();
                $payment->amount = $paymentIntent->amount / 100;
                $payment->payment_method = "Stripe";
                $payment->save();

                return response()->json(['success' => 'Payment successful!']);
            } else {
                return response()->json(['error' => 'Payment not successful.']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
