<?php

namespace App\Jobs\PaymentMethod;

use App\Models\NgeniusGateway;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NgeniusGatewayJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public $payment;

    /**
     * Create a new job instance.
     */
    public function __construct() // NgeniusGateway $payment
    {
        //$this->payment = $payment;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // No records to process
        if (NgeniusGateway::count() == 0) {
            return; // Exit early if no records to process
        }

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

        $references = NgeniusGateway::all();

        foreach ($references as $reference) {
            // \Log::info($reference);
            $response = $client->request('GET', $checkout_url . '/transactions/outlets/' . $reference->outlet_id . '/orders/' . $reference->reference, [
                'headers' => [
                    'Authorization' => $tokenType . ' ' . $accessToken,
                    'accept' => 'application/vnd.ni-payment.v2+json',
                ],
                'verify' => $verify,
            ]);
    
            // $data = $response->getBody();
            // \Log::info($data);
            $responseData = json_decode($response->getBody(), true);
            $resultCode = $responseData['_embedded']['payment'][0]['authResponse']['resultCode'];
    
            if ($resultCode == '00') {
                // Create new payment instance and save
                $payment = new Payment();
                $payment->transaction_number = $reference->reference;
                $payment->invoice_id = $reference->invoice_id;
                $payment->transaction_date = now();
                $payment->amount = $reference->amount;
                $payment->payment_method = DiligentCreators('ngenius_hosted_checkout_display_name');
                $payment->save();

                // Delete After Updating Payment
                $reference->delete();
            }
        }
    }
}
