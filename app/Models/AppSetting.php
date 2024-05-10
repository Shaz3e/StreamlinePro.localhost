<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_replace(' ', '_', strtolower($value));
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = str_replace(' ', '_', $value);
    }
}
