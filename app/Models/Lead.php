<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_NEW = 'New';
    const STATUS_CONTACTED = 'Contacted';
    const STATUS_QUALIFIED = 'Qualified';
    const STATUS_CONVERTED = 'Converted';
    const STATUS_CLOSED = 'Closed';
    const STATUS_CANCELLED = 'Cancelled';

    protected $fillable = [
        'name',
        'company',
        'country',
        'email',
        'phone',
        'product',
        'message',
        'status',
        'created_by',
        'updated_by',
        'assigned_by',
        'assigned_to',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get Invoice statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_NEW,
            self::STATUS_CONTACTED,
            self::STATUS_QUALIFIED,
            self::STATUS_CONVERTED,
            self::STATUS_CLOSED,
            self::STATUS_CANCELLED,
        ];
    }

    public function setStatus($status)
    {
        if (in_array($status, self::getStatuses())) {
            $this->status = $status;
            $this->save();
        }
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getStatusColor()
    {
        switch ($this->status) {
            case self::STATUS_NEW:
                return 'bg-dark';
            case self::STATUS_CONTACTED:
                return 'bg-info';
            case self::STATUS_QUALIFIED:
                return 'bg-warning';
            case self::STATUS_CONVERTED:
                return 'bg-primary';
            case self::STATUS_CLOSED:
                return 'bg-success';
            case self::STATUS_CANCELLED:
                return 'bg-light';
        }
    }

    public function scopeLeadsWithSameEmailOrPhone($query)
    {
        return $query->whereIn('email', function ($subQuery) {
            $subQuery->select('email')
                ->from('leads')
                ->groupBy('email')
                ->havingRaw('COUNT(*) > 1');
        })->orWhereIn('phone', function ($subQuery) {
            $subQuery->select('phone')
                ->from('leads')
                ->groupBy('phone')
                ->havingRaw('COUNT(*) > 1');
        });
    }

    /**
     * Created by Admin relationship
     */
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Updated by Admin relationship
     */
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    /**
     * Assigned By Admin relationship
     */
    public function assignedBy()
    {
        return $this->belongsTo(Admin::class, 'assigned_by');
    }

    /**
     * Assigned To Admin relationship
     */
    public function assignedTo()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }
}
