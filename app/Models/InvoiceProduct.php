<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    use HasFactory;

    // table name is invoice_product
    protected $table = 'invoice_product';

    // timestamp false
    public $timestamps = false;

    // fillable as guarded
    protected $fillable = [
        'invoice_id',
        'product_name',
        'quantity',
        'unit_price',
        'tax',
        'discount',
        'total_price'
    ];
}
