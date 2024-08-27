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
        if ($admin->hasRole('developer')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, AppSetting $appSetting)
    {
        if ($admin->hasRole('developer')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->hasRole('developer')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, AppSetting $appSetting)
    {
        if ($admin->hasRole('developer')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, AppSetting $appSetting)
    {
        if ($admin->hasRole('developer')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, AppSetting $appSetting)
    {
        if ($admin->hasRole('developer')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, AppSetting $appSetting)
    {
        if ($admin->hasRole('developer')) {
            return true;
        }
    }

    /**
     * General Setting
     */
    public function general(Admin $admin)
    {
        if ($admin->canAny(['general-setting.list', 'general-setting.read'])) {
            return true;
        }
    }

    public function generalStore(Admin $admin)
    {
        if ($admin->can('general-setting.update')) {
            return true;
        }
    }

    /**
     * Authentication Setting
     */
    public function authentication(Admin $admin)
    {
        if ($admin->canAny(['authentication-setting.list', 'authentication-setting.read'])) {
            return true;
        }
    }

    public function authenticationStore(Admin $admin)
    {
        if ($admin->can('authentication-setting.update')) {
            return true;
        }
    }

    /**
     * Dashboard Setting
     */
    public function dashboard(Admin $admin)
    {
        if ($admin->canAny(['dashboard-setting.list', 'dashboard-setting.read'])) {
            return true;
        }
    }

    public function dashboardStore(Admin $admin)
    {
        if ($admin->can('dashboard-setting.update')) {
            return true;
        }
    }

    /**
     * Payment Method Setting
     */
    public function paymentMethod(Admin $admin)
    {
        if ($admin->canAny(['payment-method-setting.list', 'payment-method-setting.read'])) {
            return true;
        }
    }

    public function paymentMethodStore(Admin $admin)
    {
        if ($admin->can('payment-method-setting.update')) {
            return true;
        }
    }

    /**
     * Mail Setting
     */
    public function mail(Admin $admin)
    {
        if ($admin->canAny(['mail-setting.list', 'mail-setting.read'])) {
            return true;
        }
    }
    public function mailStore(Admin $admin)
    {
        if ($admin->can('mail-setting.update')) {
            return true;
        }
    }

    /**
     * Currency Setting
     */
    public function currency(Admin $admin)
    {
        if ($admin->canAny(['currency-setting.list', 'currency-setting.read'])) {
            return true;
        }
    }

    public function currencyStore(Admin $admin)
    {
        if ($admin->can('currency-setting.update')) {
            return true;
        }
    }

    /**
     * SMS Setting
     */
    public function sms(Admin $admin)
    {
        if ($admin->canAny(['sms-setting.list', 'sms-setting.read'])) {
            return true;
        }
    }

    public function smsStore(Admin $admin)
    {
        if ($admin->can('sms-setting.update')) {
            return true;
        }
    }
    /**
     * Live Chat Setting
     */
    public function tawkToChat(Admin $admin)
    {
        if ($admin->canAny(['tawk-to-chat-setting.list', 'tawk-to-chat-setting.read'])) {
            return true;
        }
    }

    public function tawkToChatStore(Admin $admin)
    {
        if ($admin->can('tawk-to-chat-setting.update')) {
            return true;
        }
    }

    /**
     * CronJob Setting
     */
    public function cronjobs(Admin $admin)
    {
        if ($admin->canAny(['cronjobs-setting.list', 'cronjobs-setting.read'])) {
            return true;
        }
    }

    public function cronjobsStore(Admin $admin)
    {
        if ($admin->can('cronjobs-setting.update')) {
            return true;
        }
    }
}
