<?php

namespace App\Policies;

use App\Models\KnowledgebaseCategory;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class KnowledgebaseCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('knowledgebase-category.list')){
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, KnowledgebaseCategory $knowledgebaseCategory)
    {
        if($admin->can('knowledgebase-category.read')){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if($admin->can('knowledgebase-category.create')){
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, KnowledgebaseCategory $knowledgebaseCategory)
    {
        if($admin->can('knowledgebase-category.update')){
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, KnowledgebaseCategory $knowledgebaseCategory)
    {
        if($admin->can('knowledgebase-category.delete')){
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, KnowledgebaseCategory $knowledgebaseCategory)
    {
        if($admin->can('knowledgebase-category.restore')){
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, KnowledgebaseCategory $knowledgebaseCategory)
    {
        if($admin->can('knowledgebase-category.forece.delete')){
            return true;
        }
    }
}
