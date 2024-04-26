<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Promotion\StorePromotionRequest;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', Promotion::class);

        return view('admin.promotion.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', Promotion::class);

        return view('admin.promotion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', Promotion::class);

        // Validate data
        $validated = $request->validated();

        // Upload Image
        $validated['image'] = $request->file('image')->store('promotions', 'public');

        // Update record in database
        Promotion::create($validated);

        session()->flash('success', 'Promotion has been created successfully!');

        return redirect()->route('admin.promotions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        // Check Authorize
        Gate::authorize('read', $promotion);

        $audits = $promotion->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.promotion.show', [
            'promotion' => $promotion,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        // Check Authorize
        Gate::authorize('update', $promotion);

        return view('admin.promotion.edit', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePromotionRequest $request, Promotion $promotion)
    {
        // Check Authorize
        Gate::authorize('update', $promotion);

        // Validate data
        $validated = $request->validated();

        // Upload Image if filled
        if ($request->hasFile('image')) {
            // Delete old image
            File::delete('storage/' . $promotion->image);

            // upload new image
            $validated['image'] = $request->file('image')->store('promotions', 'public');
        }

        // Update record in database
        $promotion->update($validated);

        // Flash message
        session()->flash('success', 'Promotion has been updated successfully!');

        // Redirect to index
        return redirect()->route('admin.promotions.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', Promotion::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.promotion.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.promotions.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('delete', Promotion::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.promotions.index');
    }
}
