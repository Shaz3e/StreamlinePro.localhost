<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Invoice extends Model implements Auditable
{
    use HasFactory, AuditingAuditable, SoftDeletes;

    const STATUS_UNPAID = 'Unpaid';
    const STATUS_PARTIALLY_PAID = 'Partially Paid';
    const STATUS_PAID = 'Paid';
    const STATUS_CANCELLED = 'Cancelled';

    protected $guarded = [];

    // SoftDeletes
    protected $dates = ['deleted_at'];

    protected $casts = [
        'invoice_date'  => 'date',
        'due_date'      => 'date',
        'published_on'  => 'date',
    ];

    /**
     * Get Invoice statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_UNPAID,
            self::STATUS_PARTIALLY_PAID,
            self::STATUS_PAID,
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
            case self::STATUS_UNPAID:
                return 'bg-danger';
            case self::STATUS_PARTIALLY_PAID:
                return 'bg-warning';
            case self::STATUS_PAID:
                return 'bg-success';
            case self::STATUS_CANCELLED:
                return 'bg-default';
        }
    }

    /**
     * User Relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Company Relationship
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Product Relationship
     */
    public function products()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    /**
     * Invoice Label Relations
     */
    public function label()
    {
        return $this->belongsTo(InvoiceLabel::class, 'invoice_label_id');
    }

    /**
     * Invoice Payment Transaction relationship
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    /**
     * setAuditInclude
     * Audit log include all column in the table
     *
     * @return void
     */
    protected function setAuditInclude()
    {
        // Get all columns from the model's table
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        // Set the $auditInclude property to include all columns
        $this->auditInclude = $columns;
    }
}
