<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\TaskLabel;

class TaskLabelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('task-label.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, TaskLabel $taskLabel)
    {
        if ($admin->can('task-label.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('task-label.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, TaskLabel $taskLabel)
    {
        if ($admin->can('task-label.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, TaskLabel $taskLabel)
    {
        if ($admin->can('task-label.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, TaskLabel $taskLabel)
    {
        if ($admin->can('task-label.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, TaskLabel $taskLabel)
    {
        if ($admin->can('task-label.force.delete')) {
            return true;
        }
    }
}
