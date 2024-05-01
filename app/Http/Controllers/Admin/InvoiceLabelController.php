<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvoiceLabel\StoreInvoiceLabelRequest;
use App\Models\InvoiceLabel;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class InvoiceLabelController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', InvoiceLabel::class);

        return view('admin.invoice-label.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', InvoiceLabel::class);

        return view('admin.invoice-label.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceLabelRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', InvoiceLabel::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $invoiceLabel = InvoiceLabel::create($validated);

        session()->flash('success', 'Invoice Label has been created successfully!');
        
        return $this->saveAndRedirect($request, 'invoice-labels', $invoiceLabel->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceLabel $invoiceLabel)
    {
        // Check Authorize
        Gate::authorize('view', $invoiceLabel);

        $audits = $invoiceLabel->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.invoice-label.show', [
            'invoiceLabel' => $invoiceLabel,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceLabel $invoiceLabel)
    {
        // Check Authorize
        Gate::authorize('update', $invoiceLabel);

        return view('admin.invoice-label.edit', [
            'invoiceLabel' => $invoiceLabel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreInvoiceLabelRequest $request, InvoiceLabel $invoiceLabel)
    {
        // Check Authorize
        Gate::authorize('update', $invoiceLabel);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $invoiceLabel->update($validated);

        // Flash message
        session()->flash('success', 'Invoice Label has been updated successfully!');
        
        return $this->saveAndRedirect($request, 'invoice-labels', $invoiceLabel->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', InvoiceLabel::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.invoice-label.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.invoice-labels.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {        
        // Check Authorize
        Gate::authorize('delete', InvoiceLabel::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.todo-labels.index');
    }
}
