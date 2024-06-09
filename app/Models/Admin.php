<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, HasRoles, AuditingAuditable, SoftDeletes;

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'mobile',
    ];

    // SoftDeletes
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function setAuditInclude()
    {
        // Get all columns from the model's table
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        // Set the $auditInclude property to include all columns
        $this->auditInclude = $columns;
    }

    protected $casts = [
        'department_id' => 'array', // Tells Laravel to cast the column to an array
    ];
    
    public function lock()
    {
        $this->is_locked = true;
        $this->save();
    }

    public function unlock()
    {
        $this->is_locked = false;
        $this->save();
    }

    /**
     * Relationship to show admin department 
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'admin_department', 'admin_id', 'department_id');
    }

    /**
     * Relationship to show admin not started tasks
     */
    public function pendingTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to', 'id')->where('is_started', 0);
    }

    /**
     * Relationship to show admin incomplete tasks
     */

    public function incompleteTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to', 'id')
            ->where('is_started', 1)
            ->where('is_completed', 0);
    }


    /**
     * Relationship to show admin overdue tasks
     */
    public function overdueTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to', 'id')
            ->where('is_started', 1)
            ->where('is_completed', 0)
            ->where('due_date', '<', now());
    }
}
