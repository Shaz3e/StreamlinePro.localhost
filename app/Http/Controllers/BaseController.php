<?php

namespace App\Http\Controllers;

use App\Services\BellNotificationService;

class BaseController extends Controller
{
    protected $bell;

    public function __construct(BellNotificationService $bell)
    {
        $this->bell = $bell;
    }
}
