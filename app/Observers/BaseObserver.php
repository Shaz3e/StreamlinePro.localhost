<?php

namespace App\Observers;

use App\Services\BellNotificationService;

class BaseObserver
{
    protected $bell;

    public function __construct(BellNotificationService $bell)
    {
        $this->bell = $bell;
    }
}
