<?php

namespace App\Http\Controllers\Admin\Knowledgebase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Knowledgebase\KnowledgebaseCategoryRequest;
use App\Models\KnowledgebaseCategory;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class KnowledgebaseCategoryController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', KnowledgebaseCategory::class);

        return view('admin.knowledgebase.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', KnowledgebaseCategory::class);

        return view('admin.knowledgebase.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KnowledgebaseCategoryRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', KnowledgebaseCategory::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $category = KnowledgebaseCategory::create($validated);

        session()->flash('success', 'Knowledgebase Category has been created successfully!');
        
        return $this->saveAndRedirect($request, 'knowledgebase.categories', $category->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(KnowledgebaseCategory $category)
    {
        // Check Authorize
        Gate::authorize('view', $category);

        $audits = $category->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.knowledgebase.category.show', [
            'category' => $category,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KnowledgebaseCategory $category)
    {
        // Check Authorize
        Gate::authorize('update', $category);

        return view('admin.knowledgebase.category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KnowledgebaseCategoryRequest $request, KnowledgebaseCategory $category)
    {
        // Check Authorize
        Gate::authorize('update', $category);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $category->update($validated);

        // Flash message
        session()->flash('success', 'Knowledgebaes Category has been updated successfully!');
        
        return $this->saveAndRedirect($request, 'knowledgebase.categories', $category->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', KnowledgebaseCategory::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.knowledgebase.category.audit', [
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
        Gate::authorize('delete', KnowledgebaseCategory::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.knowledgebase.categories.index');
    }
}
