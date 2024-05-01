<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\TodoLabel;

class TodoLabelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('todo-label.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, TodoLabel $todoLabel)
    {
        if ($admin->can('todo-label.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('todo-label.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, TodoLabel $todoLabel)
    {
        if ($admin->can('todo-label.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, TodoLabel $todoLabel)
    {
        if ($admin->can('todo-label.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, TodoLabel $todoLabel)
    {
        if ($admin->can('todo-label.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, TodoLabel $todoLabel)
    {
        if ($admin->can('todo-label.force.delete')) {
            return true;
        }
    }
}
