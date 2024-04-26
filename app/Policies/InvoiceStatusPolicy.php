<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\InvoiceStatus;

class InvoiceStatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('invoice-status.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, InvoiceStatus $invoiceStatus)
    {
        if ($admin->can('invoice-status.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('invoice-status.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, InvoiceStatus $invoiceStatus)
    {
        if ($admin->can('invoice-status.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, InvoiceStatus $invoiceStatus)
    {
        if ($admin->can('invoice-status.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, InvoiceStatus $invoiceStatus)
    {
        if ($admin->can('invoice-status.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, InvoiceStatus $invoiceStatus)
    {
        if ($admin->can('invoice-status.force.delete')) {
            return true;
        }
    }
}
