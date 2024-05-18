<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    // timestamp false
    public $timestamps = false;

    // fillable as guarded
    protected $fillable = [
        'invoice_id',
        'item_description',
        'quantity',
        'unit_price',
        'discount_value',
        'tax_value',
        'product_total',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
