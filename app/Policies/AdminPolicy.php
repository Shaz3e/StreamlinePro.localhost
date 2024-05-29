<?php

namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('staff.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Admin $staff)
    {
        if ($admin->can('staff.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('staff.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Admin $staff)
    {
        if ($admin->can('staff.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Admin $staff)
    {
        if ($admin->can('staff.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Admin $staff)
    {
        if ($admin->can('staff.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Admin $staff)
    {
        if ($admin->can('staff.force.delete')) {
            return true;
        }
    }
}