<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'invoice_id',
        'amount',
        'transaction_date',
        'payment_method',
    ];

    protected $casts = [
        'transaction_date' => 'date'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
