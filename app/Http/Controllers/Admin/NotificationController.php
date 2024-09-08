<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        return view('admin.notification.index');
    }
}
