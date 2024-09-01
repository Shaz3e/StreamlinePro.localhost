<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_service_article', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knowledgebase_article_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_service_id')->constrained('products_services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_service_article');
    }
};
