<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\KnowledgebaseArticle;

class KnowledgebaseArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('knowledgebase-article.list')){
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, KnowledgebaseArticle $knowledgebaseArticle)
    {
        // if($admin->can('knowledgebase-article.read')){
        //     return true;
        // }
        $admin->id === $knowledgebaseArticle->author;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin)
    {
        if($admin->can('knowledgebase-article.create')){
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, KnowledgebaseArticle $knowledgebaseArticle)
    {
        // if($admin->can('knowledgebase-article.update')){
        //     return true;
        // }
        $admin->id === $knowledgebaseArticle->author;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, KnowledgebaseArticle $knowledgebaseArticle)
    {
        if($admin->can('knowledgebase-article.delete')){
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, KnowledgebaseArticle $knowledgebaseArticle)
    {
        if($admin->can('knowledgebase-article.restore')){
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, KnowledgebaseArticle $knowledgebaseArticle)
    {
        if($admin->can('knowledgebase-article.forece.delete')){
            return true;
        }
    }
}
