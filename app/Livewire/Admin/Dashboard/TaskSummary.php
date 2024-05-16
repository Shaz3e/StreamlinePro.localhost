<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Admin;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskSummary extends Component
{
    public function render()
    {
        // Get logged in admin/staff
        $loggedInStaff = Auth::guard('admin')->user();

        // Check if staff is super admin
        $staff = Admin::find($loggedInStaff->id);

        // Show all records to super admin
        if ($staff->hasRole(['superadmin', 'developer'])) {

            $taskNotStarted = Task::where('is_started', 0)->count();
            $taskNotCompleted = Task::where('is_completed', 0)->count();
            $taskOverDue = Task::where('due_date', '<', now())->where('is_completed', 0)->count();


            $totalTask = Task::where('is_completed', 1)->count();
        } else {
            $taskNotStarted = Task::where([
                'is_started' => 0,
                'assigned_to' => $loggedInStaff->id
            ])->count();

            $taskNotCompleted = Task::where([
                'is_completed' => 0,
                'assigned_to' => $loggedInStaff->id
            ])->count();

            $taskOverDue = Task::where('is_completed', 0)
                ->where('due_date', '<', now())
                ->where('assigned_to', $loggedInStaff->id)
                ->count();
                
            $totalTask = Task::where([
                'is_completed' => 1,
                'assigned_to' => $loggedInStaff->id
            ])->count();
        }


        return view('livewire.admin.dashboard.task-summary', [
            'taskNotStarted' => $taskNotStarted,
            'taskNotCompleted' => $taskNotCompleted,
            'taskOverDue' => $taskOverDue,
            'totalTask' => $totalTask
        ]);
    }
}
