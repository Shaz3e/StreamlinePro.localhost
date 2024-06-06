<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webhook\WebhookNgeniusNetworkController;

Route::post('/webhook/ngenius-network', [WebhookNgeniusNetworkController::class, 'handleWebhook']);
