<?php

namespace App\Http\Controllers\Admin\Knowledgebase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Knowledgebase\KnowledgebaseArticleRequest;
use App\Models\Admin;
use App\Models\KnowledgebaseArticle;
use App\Models\KnowledgebaseCategory;
use App\Models\ProductService;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class KnowledgebaseArticleController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', KnowledgebaseArticle::class);

        return view('admin.knowledgebase.article.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', KnowledgebaseArticle::class);

        // Get all active knowledagebase categories
        $categories = KnowledgebaseCategory::where('is_active', 1)->get();

        // Get all active authors from admins table
        $authors = Admin::where('is_active', 1)->get();

        // Get all products/services
        $products = ProductService::all();

        return view('admin.knowledgebase.article.create', [
            'categories' => $categories,
            'authors' => $authors,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KnowledgebaseArticleRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', KnowledgebaseArticle::class);

        // Validate data
        $validated = $request->validated();

        // Upload featured_image if provided
        if ($request->hasFile('featured_image')) {
            $filename = $request->slug . '.' . $request->file('featured_image')->extension();
            $validated['featured_image'] = $request->file('featured_image')
                ->storeAs('knowledgebase/articles', $filename, 'public');
        }

        // Update record in database
        $article = KnowledgebaseArticle::create($validated);

        if ($request->has('product_service')) {
            $article->products()->sync($request->product_service);
        }

        session()->flash('success', 'Knowledgebase Article has been created successfully!');

        return $this->saveAndRedirect($request, 'knowledgebase.articles', $article->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(KnowledgebaseArticle $article)
    {
        // Check Authorize
        Gate::authorize('view', $article);

        $audits = $article->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.knowledgebase.article.show', [
            'article' => $article,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KnowledgebaseArticle $article)
    {
        // Check Authorize
        Gate::authorize('update', $article);

        // Get all active knowledagebase categories
        $categories = KnowledgebaseCategory::where('is_active', 1)->get();

        // Get all active authors from admins table
        $authors = Admin::where('is_active', 1)->get();

        // Get products/services
        $products = ProductService::all();

        // Get article listed in products/services
        $articleProducts = $article->products->pluck('id')->toArray();

        return view('admin.knowledgebase.article.edit', [
            'article' => $article,
            'categories' => $categories,
            'authors' => $authors,
            'products' => $products,
            'articleProducts' => $articleProducts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KnowledgebaseArticleRequest $request, KnowledgebaseArticle $article)
    {
        // Check Authorize
        Gate::authorize('update', $article);

        // Validate data
        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            // Remove old logo file
            if ($article->featured_image) {
                File::delete('storage/' . $article->logo);
            }
            // Upload new logo
            $filename = $request->slug . '.' . $request->file('featured_image')->extension();
            $validated['featured_image'] = $request->file('featured_image')->storeAs('knowledgebase/articles', $filename, 'public');
        } else {
            // Unset logo key from validated array
            unset($validated['featured_image']);
        };

        // Update record in database
        $article->update($validated);

        $article->products()->sync($request->product_service);

        // Flash message
        session()->flash('success', 'Knowledgebaes Article has been updated successfully!');

        return $this->saveAndRedirect($request, 'knowledgebase.articles', $article->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', KnowledgebaseArticle::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.knowledgebase.articles.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.knowledgebase.categories.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('delete', KnowledgebaseArticle::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.knowledgebase.categories.index');
    }
}
