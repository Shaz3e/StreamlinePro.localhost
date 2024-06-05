<?php

namespace App\Http\Controllers\User\PaymentMethods\NgeniusNetwork;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class NgeniusNetworkController extends Controller
{
    public function hostedCheckout(Request $request)
    {
        $invoice = Invoice::find($request->invoice_id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        // Get currency
        $currency = currency(DiligentCreators('currency'), ['name'])['name'];

        // Get max amount
        $maxAmount = $invoice->total - $invoice->total_paid;

        // Convert amount to cents
        $amountInCents = $maxAmount * 100;

        $apikey = config('ngenius.api_key');
        $outlet = config('ngenius.outlet');
        $checkout_url = config('ngenius.' . config('ngenius.environment') . '.checkout_url');

        // Disable SSL verification on production
        if (config('app.env') == 'local') {
            $verify = false;
        } else {
            $verify = true;
        }

        // Generate Access Token
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $checkout_url . '/identity/auth/access-token', [
            'headers' => [
                'Authorization' => 'Basic ' . $apikey,
                'accept' => 'application/vnd.ni-identity.v1+json',
                'content-type' => 'application/vnd.ni-identity.v1+json',
            ],
            'verify' => $verify,
        ]);


        $responseData = json_decode($response->getBody(), true);

        // Get Access Token
        $accessToken = $responseData['access_token'];

        // Step 2: Send the second request with the access token
        $response = $client->request('POST', $checkout_url . '/transactions/outlets/' . $outlet . '/orders', [
            'json' => [
                'action' => 'PURCHASE',
                'amount' => [
                    'currencyCode' => $currency,
                    'value' => $amountInCents,
                ],
                "language" => "en",
                "emailAddress" => $invoice->user->email,
                "billingAddress" => [
                    "firstName" => $invoice->user->first_name,
                    "lastName" => $invoice->user->last_name,
                    "address1" => $invoice->user->address,
                    "city" => $invoice->user->city,
                    "countryCode" => $invoice->country->iso3
                ],
                "merchantOrderReference" => $invoice->id,
                "merchantAttributes" => [
                    "cancelUrl" => route('invoice.show', $invoice->id),
                    "cancelText" => "Cancel",
                    // "redirectUrl" => config('ngenius.domain') . "/payment-method/ngenius-network?",
                ],
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'accept' => 'application/vnd.ni-payment.v2+json',
                'content-type' => 'application/vnd.ni-payment.v2+json',
            ],
            'verify' => $verify
        ]);
        
        $output = json_decode($response->getBody(), true);

        if (isset($output['_links']['payment']['href'])) {
            $payment_link = $output['_links']['payment']['href'];
        } else {
            echo "Error fetching payment link.";
            exit();
        }
        return redirect()->away($payment_link);
    }

    public function processPayment(Request $request)
    {
        //
    }

    public function handlePaymentConfirmation(Request $request)
    {
        return 'handle payment confirmation';
    }
    public function handleHostedPaymentConfirmation(Request $request)
    {
        // ref=f1cea9e0-c08f-4441-94ac-efec767f51dc
        if ($request->has('ref')) {

            $ref = $request->ref;

            $checkout_url = config('ngenius.' . config('ngenius.environment') . '.checkout_url');

            
            // Disable SSL verification on production
            if (config('app.env') == 'local') {
                $verify = false;
            } else {
                $verify = true;
            }
            
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $checkout_url . '/identity/auth/access-token', [
                'headers' => [
                    'Authorization' => 'Basic ' . config('ngenius.api_key'),
                    'accept' => 'application/vnd.ni-identity.v1+json',
                    'content-type' => 'application/vnd.ni-identity.v1+json',
                ],
                'verify' => $verify,
            ]);

            $responseData = json_decode($response->getBody(), true);

            $accessToken = $responseData['access_token'];
            $tokenType = $responseData['token_type'];

            // Disable SSL verification on production
            if (config('app.env') == 'local') {
                $verify = false;
            } else {
                $verify = true;
            }

            $response = $client->request('GET', $checkout_url . '/transactions/outlets/3bb23c22-489e-4fb8-941c-eb8b166547b2/orders/' . $ref, [
                'headers' => [
                    'Authorization' => $tokenType . ' ' . $accessToken,
                    'accept' => 'application/vnd.ni-payment.v2+json',
                ],
                'verify' => $verify,
            ]);

            // echo $response->getBody();
            $responseData = json_decode($response->getBody(), true);

            $merchantOrderReference = $responseData['merchantOrderReference'];
            $reference = $responseData['_embedded']['payment'][0]['reference'];
            $resultCode = $responseData['_embedded']['payment'][0]['authResponse']['resultCode'];
            $amount = $responseData['amount']['value'];

            if ($resultCode == '00') {
                // Create new payment instance and save
                $payment = new Payment();
                $payment->transaction_number = $reference;
                $payment->invoice_id = $merchantOrderReference;
                $payment->transaction_date = now();
                $payment->amount = $amount / 100;
                $payment->payment_method = DiligentCreators('ngenius_hosted_checkout_display_name');
                $payment->save();

                session()->flash('success', 'Payment successful!');
                return redirect()->route('invoice.show', $merchantOrderReference);
            } else {
                session()->flash('error', 'Payment failed!');
                return redirect()->route('invoice.show', $merchantOrderReference);
            }
        }

        session()->flash('error', 'Invalid Reference Code!');
        return redirect()->route('dashboard');
    }
}
