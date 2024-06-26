<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory, SoftDeletes;    

    const STATUS_PENDING = 'Pending';
    const STATUS_SENT = 'Sent';
    const STATUS_FAILED = 'Failed';

    protected $fillable = [
        'email',
        'subject',
        'content',
        'send_date',
        'status',
    ];

    // SoftDeletes
    protected $dates = ['deleted_at'];

    /**
     * Get Email statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_SENT,
            self::STATUS_FAILED,
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
            case self::STATUS_PENDING:
                return 'bg-info';
            case self::STATUS_FAILED:
                return 'bg-warning';
            case self::STATUS_SENT:
                return 'bg-success';
        }
    }
}
