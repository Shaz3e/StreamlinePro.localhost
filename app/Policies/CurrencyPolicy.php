<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Currency;

class CurrencyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('currency.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Currency $currency)
    {
        if ($admin->can('currency.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('currency.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Currency $currency)
    {
        if ($admin->can('currency.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Currency $currency)
    {
        if ($admin->can('currency.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Currency $currency)
    {
        if ($admin->can('currency.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Currency $currency)
    {
        if ($admin->can('currency.force.delete')) {
            return true;
        }
    }
}
