<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class DashboardSettingController extends Controller
{
    public function dashboard()
    {
        // Check authorize
        Gate::authorize('dashboard', AppSetting::class);

        $roles = Role::all();

        return view('admin.app-setting.main', [
            'roles' => $roles,
        ]);
    }

    public function dashboardStore(Request $request)
    {
        // Check authorize
        Gate::authorize('dashboardStore', AppSetting::class);

        // Define validation rules for the request
        $rules = [
            'can_access_task_summary' => 'required|array|max:255',
            'can_access_user_summary' => 'required|array|max:255',
            'can_access_support_ticket_summary' => 'required|array|max:255',
            'can_access_invoice_summary' => 'required|array|max:255',
        ];

        // Validate the request data based on the rules
        $validated = $request->validate($rules);

        // Loop through each validated field and update or create the settings
        foreach ($validated as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value); // Encode the array to a JSON string
            }
            AppSetting::updateOrCreate(
                ['name' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Setting Saved');
    }
}
