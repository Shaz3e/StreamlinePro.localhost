<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\SupportTicketReply;
use Livewire\Component;

class RecentSupportTicketReply extends Component
{
    public function render()
    {
        $replies = SupportTicketReply::latest()->take(5)->get();
        return view('livewire.admin.dashboard.recent-support-ticket-reply',[
            'replies' => $replies,
        ]);
    }
}
