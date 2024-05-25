<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductService\StoreProductServiceRequest;
use App\Models\ProductService;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class ProductServiceController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', ProductService::class);

        return view('admin.product-service.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', ProductService::class);

        return view('admin.product-service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductServiceRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', ProductService::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $productService = ProductService::create($validated);

        session()->flash('success', 'Record has been created successfully!');
        
        return $this->saveAndRedirect($request, 'product-service', $productService->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductService $productService)
    {
        // Check Authorize
        Gate::authorize('read', $productService);

        $audits = $productService->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.product-service.show', [
            'productService' => $productService,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductService $productService)
    {
        // Check Authorize
        Gate::authorize('update', $productService);

        return view('admin.product-service.edit', [
            'productService' => $productService,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductServiceRequest $request, ProductService $productService)
    {
        // Check Authorize
        Gate::authorize('update', $productService);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $productService->update($validated);

        // Flash message
        session()->flash('success', 'Record has been updated successfully!');
        
        return $this->saveAndRedirect($request, 'product-service', $productService->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', ProductService::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.product-service.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.products-services.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('delete', ProductService::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.products-services.index');
    }
}

