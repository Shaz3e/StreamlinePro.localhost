<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BulkEmail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'admin_id',
        'subject',
        'content',
        'send_date',
        'is_publish',
        'is_sent',
        'is_sent_all_users',
        'is_sent_all_admins',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'user_id' => 'array',
        'admin_id' => 'array',
        'send_date' => 'datetime:Y-m-d H:i:s',
    ];

    // Use an accessor to get the users relationship
    public function getUsersAttribute()
    {
        return User::whereIn('id', $this->user_id ?: [])->get();
    }

    // Use an accessor to get the staff relationship
    public function getStaffAttribute()
    {
        return Admin::whereIn('id', $this->admin_id ?: [])->get();
    }
}
