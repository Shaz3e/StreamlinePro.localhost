<?php

namespace App\Livewire\Common\Notifications;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationList extends Component
{
    public function render()
    {
        $user = Auth::user();

        $unreadNotifications = Notification::where([
            'user_id' => $user->id,
            'read_at' => null
        ])
            ->orderBy('created_at', 'desc') // Changed to desc to get the latest notifications first
            ->get();

        return view('livewire.common.notifications.notification-list', [
            'unreadNotifications' => $unreadNotifications
        ]);
    }
}
