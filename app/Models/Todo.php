<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Todo extends Model implements Auditable
{
    use HasFactory, AuditingAuditable, SoftDeletes;

    protected $guarded = [];

    // SoftDeletes
    protected $dates = ['deleted_at'];

    protected $casts = [
        'reminder' => 'datetime:Y-m-d H:i:s',
        'closed_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected function setAuditInclude()
    {
        // Get all columns from the model's table
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        // Set the $auditInclude property to include all columns
        $this->auditInclude = $columns;
    }

    public function label()
    {
        return $this->belongsTo(TodoLabel::class, 'todo_label_id');
    }
}
