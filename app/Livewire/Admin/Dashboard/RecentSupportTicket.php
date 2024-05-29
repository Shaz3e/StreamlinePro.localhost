<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\SupportTicket;
use Livewire\Component;

class RecentSupportTicket extends Component
{
    public function render()
    {
        $supportTickets = SupportTicket::latest()->take(5)->get();
        return view('livewire.admin.dashboard.recent-support-ticket',[
            'supportTickets' => $supportTickets,
        ]);
    }
}
