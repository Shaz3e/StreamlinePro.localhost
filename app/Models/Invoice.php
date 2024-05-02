<?php

namespace App\Models;

use App\Observers\Invoice\InvoiceObserver;
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
    const STATUS_FULLY_PAID = 'Paid';
    const STATUS_CANCELLED = 'Cancelled';

    protected $guarded = [];

    // SoftDeletes
    protected $dates = ['deleted_at'];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date'     => 'date',
    ];

    /**
     * Get Invoice statuses
     */
    public static function getInvoiceStatusList()
    {
        return [
            self::STATUS_UNPAID => __('Unpaid'),
            self::STATUS_PARTIALLY_PAID => __('Partially Paid'),
            self::STATUS_FULLY_PAID => __('Paid'),
            self::STATUS_CANCELLED => __('Cancelled'),
        ];
    }

    public function setStatus($status)
    {
        // if (!in_array($status, array_keys(self::getStatuses()))) {
        //     throw new InvalidArgumentException("Invalid status");
        // }
        $this->status = $status;
        $this->save();
    }

    public function getStatus()
    {
        return self::getStatuses()[$this->status];
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
        return $this->hasMany(InvoiceProduct::class, 'invoice_id');
    }

    /**
     * Invoice Label Relations
     */
    public function label()
    {
        return $this->belongsTo(InvoiceLabel::class, 'invoice_label_id');
    }

    protected function setAuditInclude()
    {
        // Get all columns from the model's table
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        // Set the $auditInclude property to include all columns
        $this->auditInclude = $columns;
    }

    protected static function boot()
    {
        parent::boot();
        self::observe(InvoiceObserver::class);
    }
}
