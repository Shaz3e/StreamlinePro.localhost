<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->user_id == Auth::id()) {
            $notification->update(['read_at' => now()]);
            return redirect()->route('invoice.show', $notification->model_id);
        }

        return redirect()->route('dashboard')->with('error', 'Notification not found or you do not have permission.');
    }
}
