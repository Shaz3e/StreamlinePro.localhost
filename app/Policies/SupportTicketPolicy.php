<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\SupportTicket;

class SupportTicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('support-ticket.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, SupportTicket $supportTicket)
    {
        if ($admin->can('support-ticket.read')) {
            return true;
        }

        return $admin->id === $supportTicket->admin_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('support-ticket.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, SupportTicket $supportTicket)
    {
        if ($admin->can('support-ticket.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, SupportTicket $supportTicket)
    {
        if ($admin->can('support-ticket.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, SupportTicket $supportTicket)
    {
        if ($admin->can('support-ticket.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, SupportTicket $supportTicket)
    {
        if ($admin->can('support-ticket.force.delete')) {
            return true;
        }
    }
}
