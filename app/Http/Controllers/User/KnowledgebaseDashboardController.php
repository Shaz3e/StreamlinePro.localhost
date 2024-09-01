<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KnowledgebaseArticle;
use App\Models\KnowledgebaseCategory;
use Illuminate\Http\Request;

class KnowledgebaseDashboardController extends Controller
{
    /**
     * dashboard
     *
     * @return void
     */
    public function dashboard()
    {
        $knowledgebaseCategories = KnowledgebaseCategory::where('is_active', true)
            ->get();

        $knowledgebaseArticles = KnowledgebaseArticle::with('products')
            ->where('is_published', true)
            ->latest()
            ->paginate(10);

        return view('user.knowledgebase.dashboard', [
            'knowledgebaseCategories' => $knowledgebaseCategories,
            'knowledgebaseArticles' => $knowledgebaseArticles,
        ]);
    }

    /**
     * categories
     *
     * @param  mixed $request
     * @param  mixed $slug
     * @return void
     */
    public function categories(Request $request, $slug)
    {
        // Get the category by slug
        $category = KnowledgebaseCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Fetch articles related to the category
        $knowledgebaseArticles = KnowledgebaseArticle::with('products')
            ->where('is_published', true)
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(10);

        // Fetch all active categories
        $knowledgebaseCategories = KnowledgebaseCategory::where('is_active', true)
            ->get();

        return view('user.knowledgebase.categories', [
            'knowledgebaseCategories' => $knowledgebaseCategories,
            'knowledgebaseArticles' => $knowledgebaseArticles,
            'currentCategory' => $category,
        ]);
    }

    public function article(Request $request, $slug)
    {
        $article = KnowledgebaseArticle::with('products')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Fetch all active categories
        $knowledgebaseCategories = KnowledgebaseCategory::where('is_active', true)
            ->get();

        $products = $article->products;

        return view('user.knowledgebase.article', [
            'article' => $article,
            'knowledgebaseCategories' => $knowledgebaseCategories,
        ]);
    }
}
