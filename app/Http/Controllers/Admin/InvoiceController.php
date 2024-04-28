<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Invoice\StoreInvoiceRequest;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\InvoiceStatus;
use App\Models\Product;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Models\Audit;

class InvoiceController extends Controller
{
    use FormHelper;

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
                'discount_type' => 'nullable',
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

        if (
            $request->has('product_name') ||
            $request->has('quantity') ||
            $request->has('unit_price') ||
            $request->has('tax') ||
            $request->has('discount') ||
            $request->has('discount_type') ||
            $request->has('total_price')
        ) {
            // Extract the product details from the request
            $productNames = $request->input('product_name');
            $quantities = $request->input('quantity');
            $unitPrices = $request->input('unit_price');
            $taxes = $request->input('tax');
            $discounts = $request->input('discount');
            $discountTypes = $request->input('discount_type');
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
                    'discount_type' => $discountTypes[$i],
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

        return $this->saveAndRedirect($request, 'invoices', $invoice->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        // Check Authorize
        Gate::authorize('read', $invoice);

        // Get invoice items
        $items = InvoiceProduct::where('invoice_id', $invoice->id)->get();

        $audits = $invoice->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.invoice.show', [
            'invoice' => $invoice,
            'items' => $items,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        // Check Authorize
        Gate::authorize('update', $invoice);

        // Get all active products
        $products = Product::where('is_active', 1)->get();

        // Get all active companies
        $companies = Company::where('is_active', 1)->get();

        // Get all active invoice status
        $invoiceStatus = InvoiceStatus::where('is_active', 1)->get();

        // Get all product items from invoice_product table for this id
        $items = InvoiceProduct::where('invoice_id', $invoice->id)->get();

        return view('admin.invoice.edit', [
            'invoice' => $invoice,
            'products' => $products,
            'companies' => $companies,
            'invoiceStatus' => $invoiceStatus,
            'items' => $items,
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
                'discount_type' => 'nullable',
                'total_price' => 'nullable',
            ],
        );

        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first());
            return redirect()->back()->withInput();
        }

        // Update invoice details
        $invoice->update([
            'company_id' => $request->company_id,
            'invoice_status_id' => $request->invoice_status_id,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
        ]);

        // Initialize sums
        $sumUnitPrice = 0;
        $sumTax = 0;
        $sumDiscount = 0;
        $sumTotalPrice = 0;

        // Handle product details
        DB::transaction(function () use ($request, $invoice, &$sumUnitPrice, &$sumTax, &$sumDiscount, &$sumTotalPrice) {
            // Fetch existing products
            $existingProducts = InvoiceProduct::where('invoice_id', $invoice->id)->get()->keyBy('id');

            // Initialize arrays to track product IDs from the request
            $productIdsFromRequest = $request->input('product_id', []);

            // Iterate through product inputs from the request
            foreach ($request->input('product_name', []) as $index => $productName) {
                $productId = $productIdsFromRequest[$index] ?? null;

                // Calculate sums
                $sumUnitPrice += (float) $request->input('unit_price', [])[$index];
                $sumTax += (float) $request->input('tax', [])[$index];
                $sumDiscount += (float) $request->input('discount', [])[$index];
                $sumTotalPrice += (float) $request->input('total_price', [])[$index];

                if ($productId && isset($existingProducts[$productId])) {
                    // Update existing product
                    $product = $existingProducts[$productId];
                    $product->product_name = $productName;
                    $product->quantity = $request->input('quantity', [])[$index];
                    $product->unit_price = $request->input('unit_price', [])[$index];
                    $product->tax = $request->input('tax', [])[$index];
                    $product->discount = $request->input('discount', [])[$index];
                    $product->discount_type = $request->input('discount_type', [])[$index];
                    $product->total_price = $request->input('total_price', [])[$index];
                    $product->save();

                    // Remove the product from the existing products array (as it's now been updated)
                    unset($existingProducts[$productId]);
                } else {
                    // Create new product
                    InvoiceProduct::create([
                        'invoice_id' => $invoice->id,
                        'product_name' => $productName,
                        'quantity' => $request->input('quantity', [])[$index],
                        'unit_price' => $request->input('unit_price', [])[$index],
                        'tax' => $request->input('tax', [])[$index],
                        'discount' => $request->input('discount', [])[$index],
                        'discount_type' => $request->input('discount_type', [])[$index],
                        'total_price' => $request->input('total_price', [])[$index],
                    ]);
                }
            }

            // Remove any products from the database that were not present in the request
            foreach ($existingProducts as $existingProduct) {
                $existingProduct->delete();
            }

            // Update invoice with calculated sums
            $invoice->update([
                'total_price' => $sumUnitPrice,
                'total_tax' => $sumTax,
                'total_discount' => $sumDiscount,
                'total_amount' => $sumTotalPrice,
            ]);
        });

        // Flash message
        session()->flash('success', 'Invoice has been updated successfully!');
        
        return $this->saveAndRedirect($request, 'invoices', $invoice->id);
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

    /**
     * Remove product item from invoice
     */
    public function removeProduct($productId)
    {
        // Find the product by its ID
        $product = InvoiceProduct::findOrFail($productId);

        // Remove the product from the database
        $product->delete();

        // Return a JSON response indicating success
        return response()->json(['success' => true]);
    }
}
