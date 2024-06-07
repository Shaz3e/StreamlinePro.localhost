<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NgeniusGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'reference',
        'outlet_id',
        'amount',
    ];
}
