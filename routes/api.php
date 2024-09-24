<?php

use App\Http\Controllers\Admin\Api\LeadController;
use Illuminate\Support\Facades\Route;

Route::post('/leads', LeadController::class);
