<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Invoice extends Model implements Auditable
{
    use HasFactory, AuditingAuditable, SoftDeletes;

    protected $guarded = [];

    // SoftDeletes
    protected $dates = ['deleted_at'];

    protected function setAuditInclude()
    {
        // Get all columns from the model's table
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        // Set the $auditInclude property to include all columns
        $this->auditInclude = $columns;
    }

    /**
     * Company Relationship
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Product Relationship
     */
    public function products()
    {
        return $this->hasMany(InvoiceProduct::class, 'invoice_id');
    }

    /**
     * Invoice Status Relations
     */
    public function status()
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }

    // $invoice = Invoice::create([...]);

    // $product1 = Product::find(1);
    // $product2 = Product::find(2);

    // $invoice->products()->attach([
    //     $product1->id => ['quantity' => 2, 'price' => 100],
    //     $product2->id => ['quantity' => 1, 'price' => 50],
    // ]);

    // $invoice = Invoice::find($id);
    // $products = $invoice->products;
}
