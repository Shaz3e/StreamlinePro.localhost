<?php

return [
    'api_key' => env('NGENIUS_APIKEY'),
    'outlet' => env('NGENIUS_OUTLET'),
    'domain' => env('NGENIUS_DOMAIN'),
    'slim_mode' => env('NGENIUS_SLIM_MODE'),

    // Set environment
    'environment' => env('NGENIUS_ENVIRONMENT', 'sandbox'), // 'live' or 'sandbox'

    'live' => [
        'checkout_url' => 'https://api-gateway.ngenius-payments.com',
    ],

    'sandbox' => [
        'checkout_url' => 'https://api-gateway.sandbox.ngenius-payments.com',
    ],
];
