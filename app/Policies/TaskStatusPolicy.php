<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\TaskStatus;

class TaskStatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('task-status.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, TaskStatus $taskStatus)
    {
        if ($admin->can('task-status.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('task-status.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, TaskStatus $taskStatus)
    {
        if ($admin->can('task-status.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, TaskStatus $taskStatus)
    {
        if ($admin->can('task-status.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, TaskStatus $taskStatus)
    {
        if ($admin->can('task-status.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, TaskStatus $taskStatus)
    {
        if ($admin->can('task-status.force.delete')) {
            return true;
        }
    }
}
