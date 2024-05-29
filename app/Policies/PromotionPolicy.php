<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Promotion;

class PromotionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('promotion.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Promotion $promotion)
    {
        if ($admin->can('promotion.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('promotion.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Promotion $promotion)
    {
        if ($admin->can('promotion.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Promotion $promotion)
    {
        if ($admin->can('promotion.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Promotion $promotion)
    {
        if ($admin->can('promotion.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Promotion $promotion)
    {
        if ($admin->can('promotion.force.delete')) {
            return true;
        }
    }
}
