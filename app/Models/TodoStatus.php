<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class TodoStatus extends Model implements Auditable
{
    use HasFactory, AuditingAuditable, SoftDeletes;

    protected $guarded = [];

    // SoftDeletes
    protected $dates = ['deleted_at'];

    protected function setAuditInclude()
    {
        // Get all columns from the model's table
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        // Set the $auditInclude property to include all columns
        $this->auditInclude = $columns;
    }

    public function todos()
    {
        return $this->hasMany(Todo::class, 'todo_status_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($todoStatus) {
            $todoStatus->todos()->where('todo_status_id', $todoStatus->id)->update(['todo_status_id' => null]);
        });
    }
}
