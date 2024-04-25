<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\TodoStatus;

class TodoStatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('todo-status.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, TodoStatus $todoStatus)
    {
        if ($admin->can('todo-status.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('todo-status.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, TodoStatus $todoStatus)
    {
        if ($admin->can('todo-status.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, TodoStatus $todoStatus)
    {
        if ($admin->can('todo-status.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, TodoStatus $todoStatus)
    {
        if ($admin->can('todo-status.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, TodoStatus $todoStatus)
    {
        if ($admin->can('todo-status.force.delete')) {
            return true;
        }
    }
}
