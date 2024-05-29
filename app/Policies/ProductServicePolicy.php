<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\ProductService;

class ProductServicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('product-service.list')){
            return true;
        }
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, ProductService $productService)
    {
        if ($admin->can('product-service.read')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if ($admin->can('product-service.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, ProductService $productService)
    {
        if ($admin->can('product-service.update')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, ProductService $productService)
    {
        if ($admin->can('product-service.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, ProductService $productService)
    {
        if ($admin->can('product-service.restore')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, ProductService $productService)
    {
        if ($admin->can('product-service.force.delete')) {
            return true;
        }
    }
}
