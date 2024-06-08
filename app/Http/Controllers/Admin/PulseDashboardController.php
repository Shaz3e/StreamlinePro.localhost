<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class PulseDashboardController extends Controller
{
    public function dashboard()
    {
        // Get the allowed roles from DiligentCreators
        $allowedRoles = json_decode(DiligentCreators('can_access_pulse_dashboard'));

        // Get the authenticated user
        $admin = Auth::user();

        // Check if the user has any of the allowed roles
        $hasAccess = false;

        foreach ($allowedRoles as $role) {
            if ($admin->hasRole($role)) {
                $hasAccess = true;
                break;
            }
        }

        // Abort with a 403 response if the user does not have access
        if (!$hasAccess) {
            session()->flash('error', 'This action is unauthorized');
            return redirect()->route('admin.dashboard');
        }

        // Render the Pulse dashboard view
        return view('vendor.pulse.dashboard');
    }
}
