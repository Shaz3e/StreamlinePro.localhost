<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\AppSetting;

class AppSettingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->hasRole('developer')){
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, AppSetting $appSetting)
    {
        if($admin->hasRole('developer')){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if($admin->hasRole('developer')){
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, AppSetting $appSetting)
    {
        if($admin->hasRole('developer')){
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, AppSetting $appSetting)
    {
        if($admin->hasRole('developer')){
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, AppSetting $appSetting)
    {
        if($admin->hasRole('developer')){
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, AppSetting $appSetting)
    {
        if($admin->hasRole('developer')){
            return true;
        }
    }

    /**
     * General Setting
     */
    public function general(Admin $admin)
    {
        if($admin->canAny(['general-setting.list', 'general-setting.read'])){
            return true;
        }
    }

    public function generalStore(Admin $admin)
    {
        if($admin->can('general-setting.update')){
            return true;
        }
    }

    /**
     * Authentication Setting
     */
    public function authentication(Admin $admin)
    {
        if($admin->canAny(['authentication-setting.list', 'authentication-setting.read'])){
            return true;
        }
    }

    public function authenticationStore(Admin $admin)
    {
        if($admin->can('authentication-setting.update')){
            return true;
        }
    }

    /**
     * Dashboard Setting
     */
    public function dashboard(Admin $admin)
    {
        if($admin->canAny(['dashboard-setting.list', 'dashboard-setting.read'])){
            return true;
        }
    }

    public function dashboardStore(Admin $admin)
    {
        if($admin->can('dashboard-setting.update')){
            return true;
        }
    }

    /**
     * Payment Method Setting
     */
    public function paymentMethod(Admin $admin)
    {
        if($admin->canAny(['payment-method-setting.list', 'payment-method-setting.read'])){
            return true;
        }
    }

    public function paymentMethodStore(Admin $admin)
    {
        if($admin->can('payment-method-setting.update')){
            return true;
        }
    }
}
