<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class SupportTicket extends Model implements Auditable
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

    /**
     * Relationship with User Table
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with Admin Table
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Relationship with Department Table
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Relationship with Support Ticket Status Table
     */
    public function status()
    {
        return $this->belongsTo(SupportTicketStatus::class, 'support_ticket_status_id');
    }

    /**
     * Relationship with Support Ticket Priority Table
     */
    public function priority()
    {
        return $this->belongsTo(SupportTicketPriority::class, 'support_ticket_priority_id');
    }

    /**
     * Relationship with Support Ticket Reply Table
     */
    public function getTicketReplies()
    {
        return $this->hasMany(SupportTicketReply::class);
    }

    /**
     * Relationship with Support Ticket Reply Table by Last Reply
     */
    public function lastReply()
    {
        return $this->hasOne(SupportTicketReply::class)->latest();
    }
}
