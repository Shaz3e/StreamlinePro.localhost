<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Todo;

class TodoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('todo.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Todo $todo)
    {
        if ($admin->can('todo.read')) {
            return true;
        }

        return $admin->id === $todo->admin_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('todo.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Todo $todo)
    {
        if ($admin->can('todo.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Todo $todo)
    {
        if ($admin->can('todo.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Todo $todo)
    {
        if ($admin->can('todo.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Todo $todo)
    {
        if ($admin->can('todo.force.delete')) {
            return true;
        }
    }
}

