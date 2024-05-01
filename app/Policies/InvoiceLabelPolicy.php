<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\InvoiceLabel;

class InvoiceLabelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('invoice-label.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, InvoiceLabel $invoiceLabel)
    {
        if ($admin->can('invoice-label.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('invoice-label.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, InvoiceLabel $invoiceLabel)
    {
        if ($admin->can('invoice-label.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, InvoiceLabel $invoiceLabel)
    {
        if ($admin->can('invoice-label.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, InvoiceLabel $invoiceLabel)
    {
        if ($admin->can('invoice-label.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, InvoiceLabel $invoiceLabel)
    {
        if ($admin->can('invoice-label.force.delete')) {
            return true;
        }
    }
}
