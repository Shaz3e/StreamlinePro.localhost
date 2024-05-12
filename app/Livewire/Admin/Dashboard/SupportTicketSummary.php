<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\SupportTicket;
use Livewire\Component;

class SupportTicketSummary extends Component
{
    public function render()
    {
        $supportTickets = SupportTicket::all();        

        $currentMonthTickets = SupportTicket::whereMonth('created_at', now()->month)->count();
        $lastMonthTickets = SupportTicket::whereMonth('created_at', now()->subMonth()->month)->count();

        return view('livewire.admin.dashboard.support-ticket-summary', [
            'supportTickets' => $supportTickets,
            'currentMonthTickets' => $currentMonthTickets,
            'lastMonthTickets' => $lastMonthTickets,
        ]);
    }

    public function getNewTicketPercentageChange()
    {
        $lastMonthTickets = SupportTicket::whereBetween('created_at', [now()->subMonth(), now()->endOfMonth()])->count();
        $thisMonthTickets = SupportTicket::whereBetween('created_at', [now()->startOfMonth(), now()])->count();
        
        if ($lastMonthTickets == 0) {
            return 0; // or any other default value you prefer
        }
        
        $percentageChange = (($thisMonthTickets - $lastMonthTickets) / $lastMonthTickets) * 100;
        
        // Update: return the absolute value of the percentage change if it's negative
        if ($percentageChange < 0) {
            return abs($percentageChange);
        }
        
        return $percentageChange;
    }
}
