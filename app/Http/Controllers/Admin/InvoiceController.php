<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Invoice\StoreInvoiceRequest;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\InvoiceStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Models\Audit;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', Invoice::class);

        return view('admin.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', Invoice::class);

        // Get all active products
        $products = Product::where('is_active', 1)->get();

        // Get all active companies
        $companies = Company::where('is_active', 1)->get();

        // Get all active invoice status
        $invoiceStatus = InvoiceStatus::where('is_active', 1)->get();

        return view('admin.invoice.create', [
            'products' => $products,
            'companies' => $companies,
            'invoiceStatus' => $invoiceStatus,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Check Authorize
        Gate::authorize('create', Invoice::class);

        // Validate data
        $validator = Validator::make(
            $request->all(),
            [
                'company_id' => 'required|exists:companies,id',
                'invoice_status_id' => 'required|exists:invoice_statuses,id',
                'invoice_date' => 'required|date',
                'due_date' => 'required|date',
                'total_tax' => 'nullable',
                'total_price' => 'nullable',
                'total_discount' => 'nullable',
                'total_amount' => 'nullable',
                'product_name' => 'nullable|max:255',
                'quantity' => 'nullable',
                'unit_price' => 'nullable',
                'tax' => 'nullable',
                'discount' => 'nullable',
                'total_price' => 'nullable',
            ],
        );

        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first());
            return redirect()->back()->withInput();
        }

        // Update record in database
        $invoice = new Invoice();
        $invoice->company_id = $request->company_id;
        $invoice->invoice_status_id = $request->invoice_status_id;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->due_date = $request->due_date;
        $invoice->save();

        if($request->has('product_name') || $request->has('quantity') || $request->has('unit_price') || $request->has('tax') || $request->has('discount') || $request->has('total_price')) {
            // Extract the product details from the request
            $productNames = $request->input('product_name');
            $quantities = $request->input('quantity');
            $unitPrices = $request->input('unit_price');
            $taxes = $request->input('tax');
            $discounts = $request->input('discount');
            $totalPrices = $request->input('total_price');
    
            // Initialize variables to store the sums
            $sumQuantity = 0;
            $sumUnitPrice = 0;
            $sumTax = 0;
            $sumDiscount = 0;
            $sumTotalPrice = 0;
    
            // Iterate through the products and calculate the sums
            for ($i = 0; $i < count($productNames); $i++) {
                $sumQuantity += (float) $quantities[$i];
                $sumUnitPrice += (float) $unitPrices[$i];
                $sumTax += (float) $taxes[$i];
                $sumDiscount += (float) $discounts[$i];
                $sumTotalPrice += (float) $totalPrices[$i];
    
                // Create entries in InvoiceProduct model
                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'product_name' => $productNames[$i],
                    'quantity' => $quantities[$i],
                    'unit_price' => $unitPrices[$i],
                    'tax' => $taxes[$i],
                    'discount' => $discounts[$i],
                    'total_price' => $totalPrices[$i],
                ]);
            }
    
            // Update Invoice model with sum
            $invoice->update([
                'total_price' => $sumUnitPrice,
                'total_tax' => $sumTax,
                'total_discount' => $sumDiscount,
                'total_amount' => $sumTotalPrice,
            ]);
        }


        session()->flash('success', 'Invoce has been created successfully!');

        return redirect()->route('admin.invoices.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        // Check Authorize
        Gate::authorize('read', $invoice);

        $audits = $invoice->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.invoice.show', [
            'invoice' => $invoice,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        return $invoice;

        // Check Authorize
        Gate::authorize('update', $invoice);

        return view('admin.invoice.edit', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        // Check Authorize
        Gate::authorize('update', $invoice);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $invoice->update($validated);

        // Flash message
        session()->flash('success', 'Invoice has been updated successfully!');

        // Redirect to index
        return redirect()->route('admin.invoices.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', Invoice::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.invoice.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.invoices.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('delete', Invoice::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.invoices.index');
    }
}
