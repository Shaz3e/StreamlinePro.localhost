<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class KnowledgebaseArticle extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditingAuditable;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'content',
        'is_published',
        'featured_image',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Author relationship with admins table
     */
    public function author()
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }
    
    /**
     * Category relationship
     */
    public function category()
    {
        return $this->belongsTo(KnowledgebaseCategory::class, 'category_id');
    }

    protected function setAuditInclude()
    {
        // Get all columns from the model's table
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        // Set the $auditInclude property to include all columns
        $this->auditInclude = $columns;
    }
}
