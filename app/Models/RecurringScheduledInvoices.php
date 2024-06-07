<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringScheduledInvoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'next_invoice_date',
        'status',
    ];

    protected $casts = [
        'next_invoice_date' => 'date',
    ];

    /**
     * Invoice Relationship
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
