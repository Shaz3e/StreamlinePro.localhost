<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\SupportTicketPriority;

class SupportTicketPriorityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('ticket-priority.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, SupportTicketPriority $supportTicketPriority)
    {
        if ($admin->can('ticket-priority.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('ticket-priority.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, SupportTicketPriority $supportTicketPriority)
    {
        if ($admin->can('ticket-priority.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, SupportTicketPriority $supportTicketPriority)
    {
        if ($admin->can('ticket-priority.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, SupportTicketPriority $supportTicketPriority)
    {
        if ($admin->can('ticket-priority.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, SupportTicketPriority $supportTicketPriority)
    {
        if ($admin->can('ticket-priority.force.delete')) {
            return true;
        }
    }
}
