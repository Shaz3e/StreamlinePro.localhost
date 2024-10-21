<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KnowledgebaseArticle;
use App\Models\KnowledgebaseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KnowledgebaseDashboardController extends Controller
{
    /**
     * dashboard
     *
     * @return void
     */
    public function dashboard()
    {
        $user = Auth::user();
        $userProductIds = $user->products->pluck('id')->toArray();

        $knowledgebaseCategories = KnowledgebaseCategory::where('is_active', true)
            ->get();

        // Fetch knowledge base articles related to the user's products/services
        $knowledgebaseArticles = KnowledgebaseArticle::with('products')
            ->whereHas('products', function ($query) use ($userProductIds) {
                $query->whereIn('products_services.id', $userProductIds); // Adjusted to use 'products_services.id'
            })
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
        $user = Auth::user();
        $userProductIds = $user->products->pluck('id')->toArray();

        // Get the category by slug
        $category = KnowledgebaseCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Fetch knowledge base articles related to the user's products/services
        $knowledgebaseArticles = KnowledgebaseArticle::with('products')
            ->whereHas('products', function ($query) use ($userProductIds) {
                $query->whereIn('products_services.id', $userProductIds); // Adjusted to use 'products_services.id'
            })
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
        $user = Auth::user();

        // Fetch the article with its related products
        $article = KnowledgebaseArticle::with('products')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Get the authenticated user's assigned product IDs
        $userProductIds = $user->products->pluck('id')->toArray();

        // Check if the article has any products related to the user's products
        $hasAccess = $article->products->contains(function ($product) use ($userProductIds) {
            return in_array($product->id, $userProductIds);
        });

        // If the user does not have access to the article, redirect back with an error message
        if (!$hasAccess) {
            session()->flash('error', 'You do not have permission to view this article.');
            return redirect()->route('knowledgebase.dashboard');
        }

        // Fetch all active categories
        $knowledgebaseCategories = KnowledgebaseCategory::where('is_active', true)
            ->get();

        return view('user.knowledgebase.article', [
            'article' => $article,
            'knowledgebaseCategories' => $knowledgebaseCategories,
        ]);
    }
}
