<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'symbol',
        'is_active',
    ];

    // SoftDeletes
    protected $dates = ['deleted_at'];

    public function getData($fields = ['id', 'name', 'symbol'])
    {
        $data = [];
        foreach ($fields as $field) {
            if ($this->hasAttribute($field)) {
                $data[$field] = $this->$field;
            }
        }
        return $data;
    }
}
