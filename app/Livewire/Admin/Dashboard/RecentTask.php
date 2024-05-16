<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Admin;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentTask extends Component
{
    public function render()
    {
        // Get logged in admin/staff
        $loggedInStaff = Auth::guard('admin')->user();

        // Check if staff is super admin
        $staff = Admin::find($loggedInStaff->id);

        // Show all records to super admin
        if ($staff->hasRole(['superadmin', 'developer'])) {
            $tasks = Task::latest()->take(5)->get();
        } else {
            // Show only logged in user tasks
            $tasks = Task::where('assigned_to', $loggedInStaff->id)->latest()->take(5)->get();
        }


        return view('livewire.admin.dashboard.recent-task', [
            'tasks' => $tasks,
        ]);
    }
}
