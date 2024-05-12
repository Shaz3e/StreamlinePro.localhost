<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Payment;
use Livewire\Component;

class RecentPayments extends Component
{
    public function render()
    {
        $payments = Payment::latest()->take(5)->get();
        return view('livewire.admin.dashboard.recent-payments',[
            'payments' => $payments,
        ]);
    }
}
