<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Task;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('task.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Task $task)
    {
        if ($admin->can('task.read')) {
            return true;
        }

        return $admin->id === $task->assigned_to;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('task.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Task $task)
    {
        if ($admin->can('task.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Task $task)
    {
        if ($admin->can('task.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Task $task)
    {
        if ($admin->can('task.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Task $task)
    {
        if ($admin->can('task.force.delete')) {
            return true;
        }
    }
}
