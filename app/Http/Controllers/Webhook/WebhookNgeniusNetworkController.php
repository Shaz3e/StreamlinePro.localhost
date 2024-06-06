<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookNgeniusNetworkController extends Controller
{
    public function handleWebhook(Request $request)
    {
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
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'accept' => 'application/vnd.ni-payment.v2+json',
                'content-type' => 'application/vnd.ni-payment.v2+json',
            ],
            'verify' => $verify
        ]);

        // Handle the webhook request
        $event = $request->input('event');
        $data = $request->input('data');

        if ($event === 'PURCHASED') {
            Log::info("webhook");
        }
    }
}
