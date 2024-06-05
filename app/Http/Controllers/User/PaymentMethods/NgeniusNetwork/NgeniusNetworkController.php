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
        $checkout_url = config('ngenius.' . config('ngenius.environment') . '.checkout_url');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $checkout_url . "/identity/auth/access-token");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "accept: application/vnd.ni-identity.v1+json",
            "authorization: Basic " . $apikey,
            "content-type: application/vnd.ni-identity.v1+json"
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"realmName\":\"ni\"}");

        // Disable SSL verification on production
        if (config('app.env') == 'local') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            exit();
        } else {
            $output = json_decode($response);
            if (isset($output->access_token)) {
                $access_token = $output->access_token;
            } else {
                echo "Error fetching access token.";
                exit();
            }
        }

        curl_close($ch);


        // Step 2: Send the second request with the access token
        $outlet_id = config('ngenius.outlet');
        $url = $checkout_url . "/transactions/outlets/$outlet_id/orders";

        $currency_code = $currency;
        $email_address = $invoice->user->email;
        $first_name = $invoice->user->first_name;
        $last_name = $invoice->user->last_name; // Replace with the user's last name
        $address1 = $invoice->user->address; // Replace with the user's address
        $city = $invoice->user->city; // Replace with the user's city
        $country_code = $invoice->user->country_code; // Replace with the user's country code
        $merchant_order_reference = $invoice->id; // Replace with the reference number

        $data = array(
            "action" => "PURCHASE",
            "amount" => array(
                "currencyCode" => $currency_code,
                "value" => $amountInCents
            ),
            "language" => "en",
            "emailAddress" => $email_address,
            "billingAddress" => array(
                "firstName" => $first_name,
                "lastName" => $last_name,
                "address1" => $address1,
                "city" => $city,
                "countryCode" => $country_code
            ),
            "merchantOrderReference" => $merchant_order_reference,
            "merchantAttributes" => array(
                "cancelUrl" => route('invoice.show', $invoice->id),
                "cancelText" => "Cancel",
                "redirectUrl" => config('ngenius.domain') . "/payment-method/ngenius-network?",
            )
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $access_token,
            "Content-Type: application/vnd.ni-payment.v2+json",
            "Accept: application/vnd.ni-payment.v2+json"
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Disable SSL verification on production
        if (config('app.env') == 'local') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            exit();
        } else {
            $output = json_decode($response, true);

            if (isset($output['_links']['payment']['href'])) {
                $payment_link = $output['_links']['payment']['href'];
            } else {
                echo "Error fetching payment link.";
                exit();
            }
        }

        curl_close($ch);

        // redirect
        // header("Location: $payment_link");
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

            $client = new \GuzzleHttp\Client();

            // Disable SSL verification on production
            if (config('app.env') == 'local') {
                $verify = false;
            } else {
                $verify = true;
            }

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
