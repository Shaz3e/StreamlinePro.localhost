<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\User;
use Livewire\Component;

class UserSummary extends Component
{
    public function render()
    {
        $users = User::all();

        $currentMonthUsers = User::whereMonth('created_at', now()->month)->count();
        $lastMonthUsers = User::whereMonth('created_at', now()->subMonth()->month)->count();

        return view('livewire.admin.dashboard.user-summary', [
            'users' => $users,
            'currentMonthUsers' => $currentMonthUsers,
            'lastMonthUsers' => $lastMonthUsers,
        ]);
    }

    public function getNewUserPercentageChange()
    {
        $lastMonthNewUsers = User::whereBetween('created_at', [now()->subMonth(), now()->endOfMonth()])->count();
        $thisMonthNewUsers = User::whereBetween('created_at', [now()->startOfMonth(), now()])->count();
    
        $percentageChange = (($thisMonthNewUsers - $lastMonthNewUsers) / $lastMonthNewUsers) * 100;
    
        return $percentageChange;
    }
}
