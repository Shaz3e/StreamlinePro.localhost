<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Invoice;

class InvoicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('invoice.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Invoice $invoice)
    {
        if ($admin->can('invoice.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('invoice.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Invoice $invoice)
    {
        if ($admin->can('invoice.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Invoice $invoice)
    {
        if ($admin->can('invoice.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Invoice $invoice)
    {
        if ($admin->can('invoice.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Invoice $invoice)
    {
        if ($admin->can('invoice.force.delete')) {
            return true;
        }
    }
}