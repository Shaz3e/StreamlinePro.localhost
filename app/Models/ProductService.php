<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ProductService extends Model implements Auditable
{
    use HasFactory, AuditingAuditable, SoftDeletes;

    // Table Name
    protected $table = 'products_services';

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

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class)->withPivot('quantity', 'price');
    }

    /**
     * User product services relationship
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'product_service_user')
            ->withTimestamps();
    }

    /**
     * Knowledgebase Article Relationship
     */
    // public function articles()
    // {
    //     return $this->belongsToMany(KnowledgebaseArticle::class, 'product_service_article')
    //         ->withTimestamps();
    // }

    public function articles()
    {
        return $this->belongsToMany(KnowledgebaseArticle::class, 'product_service_article', 'product_service_id', 'knowledgebase_article_id');
    }
}
