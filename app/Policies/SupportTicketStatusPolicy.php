<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\SupportTicketStatus;

class SupportTicketStatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('ticket-status.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, SupportTicketStatus $supportTicketStatus)
    {
        if ($admin->can('ticket-status.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('ticket-status.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, SupportTicketStatus $supportTicketStatus)
    {
        if ($admin->can('ticket-status.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, SupportTicketStatus $supportTicketStatus)
    {
        if ($admin->can('ticket-status.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, SupportTicketStatus $supportTicketStatus)
    {
        if ($admin->can('ticket-status.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, SupportTicketStatus $supportTicketStatus)
    {
        if ($admin->can('ticket-status.force.delete')) {
            return true;
        }
    }
}
