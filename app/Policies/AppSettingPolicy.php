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

    public function registration(Admin $admin)
    {
        if($admin->canAny(['registration-setting.list', 'registration-setting.read'])){
            return true;
        }
    }

    public function registrationStore(Admin $admin)
    {
        if($admin->can('registration-setting.update')){
            return true;
        }
    }
}
