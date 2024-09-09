<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'posted_by',
        'message',
        'attachments',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function postedBy()
    {
        return $this->belongsTo(Admin::class, 'posted_by');
    }
}
