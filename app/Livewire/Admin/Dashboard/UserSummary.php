<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Company;
use App\Models\User;
use Livewire\Component;

class UserSummary extends Component
{
    public function render()
    {
        $users = User::latest()->take(5)->get(); // Fetch only 5 latest users
        $totalUsers = User::count(); // Get the total number of users
        $activeUsers = User::where('is_active', 1)->count();
        $inActiveUsers = User::where('is_active', 0)->count();

        $companies = Company::where('is_active', 1)->count(); // Use count() instead of get()

        $currentMonthUsers = User::whereMonth('created_at', now()->month)->count();
        $lastMonthUsers = User::whereMonth('created_at', now()->subMonth()->month)->count();

        $newUserPercentageChange = $this->getNewUserPercentageChange();

        return view('livewire.admin.dashboard.user-summary', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inActiveUsers' => $inActiveUsers,
            'companies' => $companies,
            'currentMonthUsers' => $currentMonthUsers,
            'lastMonthUsers' => $lastMonthUsers,
            'newUserPercentageChange' => $newUserPercentageChange,
        ]);
    }

    public function getNewUserPercentageChange()
    {
        $lastMonthNewUsers = User::whereBetween('created_at', [now()->subMonth(), now()->endOfMonth()])->count();
        $thisMonthNewUsers = User::whereBetween('created_at', [now()->startOfMonth(), now()])->count();

        if ($lastMonthNewUsers == 0) {
            return 0; // or any other default value you prefer
        }

        $percentageChange = (($thisMonthNewUsers - $lastMonthNewUsers) / $lastMonthNewUsers) * 100;

        return $percentageChange;
    }
}
