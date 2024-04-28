<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvoiceStatus\StoreInvoiceStatusRequest;
use App\Models\InvoiceStatus;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class InvoiceStatusController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', InvoiceStatus::class);

        return view('admin.invoice-status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', InvoiceStatus::class);

        return view('admin.invoice-status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceStatusRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', InvoiceStatus::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $invoiceStatus = InvoiceStatus::create($validated);

        session()->flash('success', 'Invoice Status has been created successfully!');
        
        return $this->saveAndRedirect($request, 'invoice-status', $invoiceStatus->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceStatus $invoiceStatus)
    {
        // Check Authorize
        Gate::authorize('view', $invoiceStatus);

        $audits = $invoiceStatus->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.invoice-status.show', [
            'invoiceStatus' => $invoiceStatus,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceStatus $invoiceStatus)
    {
        // Check Authorize
        Gate::authorize('update', $invoiceStatus);

        return view('admin.invoice-status.edit', [
            'invoiceStatus' => $invoiceStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreInvoiceStatusRequest $request, InvoiceStatus $invoiceStatus)
    {
        // Check Authorize
        Gate::authorize('update', $invoiceStatus);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $invoiceStatus->update($validated);

        // Flash message
        session()->flash('success', 'Invoice Status has been updated successfully!');
        
        return $this->saveAndRedirect($request, 'invoice-status', $invoiceStatus->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', InvoiceStatus::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.invoice-status.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.invoice-status.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {        
        // Check Authorize
        Gate::authorize('delete', InvoiceStatus::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.todo-status.index');
    }
}
