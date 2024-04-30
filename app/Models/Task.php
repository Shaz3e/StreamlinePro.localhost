<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use HasFactory, AuditingAuditable, SoftDeletes;

    protected $guarded = [];

    // SoftDeletes
    protected $dates = ['deleted_at'];

    protected $casts = [
        'start_time' => 'datetime',
        'completed_time' => 'datetime',
        'due_date' => 'datetime',
    ];

    protected function setAuditInclude()
    {
        // Get all columns from the model's table
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        // Set the $auditInclude property to include all columns
        $this->auditInclude = $columns;
    }

    /**
     * Relationship with Admin Table
     */
    public function assignee()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    /**
     * Relationship with Admin Table
     */
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Relationship with Task Status Table
     */
    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'task_status_id');
    }
}
