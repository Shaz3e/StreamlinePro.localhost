<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\BulkEmail;

class BulkEmailPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('bulk-email.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, BulkEmail $bulkEmail)
    {
        if ($admin->can('bulk-email.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('bulk-email.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, BulkEmail $bulkEmail)
    {
        if ($admin->can('bulk-email.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, BulkEmail $bulkEmail)
    {
        if ($admin->can('bulk-email.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, BulkEmail $bulkEmail)
    {
        if ($admin->can('bulk-email.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, BulkEmail $bulkEmail)
    {
        if ($admin->can('bulk-email.force.delete')) {
            return true;
        }
    }
}