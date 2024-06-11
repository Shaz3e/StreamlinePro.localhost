<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'title',
        'message',
        'type',
        'model_id',
        'route_name',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    // relationship with user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
