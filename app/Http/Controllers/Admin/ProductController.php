<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Models\Product;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class ProductController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', Product::class);

        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', Product::class);

        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', Product::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $product = Product::create($validated);

        session()->flash('success', 'Product has been created successfully!');
        
        return $this->saveAndRedirect($request, 'products', $product->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Check Authorize
        Gate::authorize('read', $product);

        $audits = $product->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.product.show', [
            'product' => $product,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Check Authorize
        Gate::authorize('update', $product);

        return view('admin.product.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        // Check Authorize
        Gate::authorize('update', $product);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $product->update($validated);

        // Flash message
        session()->flash('success', 'Product has been updated successfully!');
        
        return $this->saveAndRedirect($request, 'products', $product->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', Product::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.product.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.products.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('delete', Product::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.products.index');
    }
}

