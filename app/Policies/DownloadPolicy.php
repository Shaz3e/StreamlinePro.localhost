<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Download;

class DownloadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        return true;
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Download $download)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Download $download)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Download $download)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Download $download)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Download $download)
    {
        return true;
    }
}
