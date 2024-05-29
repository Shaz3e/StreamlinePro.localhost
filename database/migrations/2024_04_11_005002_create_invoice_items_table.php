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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->text('item_description')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->decimal('unit_price', 65, 2)->nullable()->default(0.00);
            $table->decimal('discount_value', 65, 2)->nullable()->default(0.00);
            $table->decimal('tax_value', 65, 2)->nullable()->default(0.00);
            $table->decimal('product_total', 65, 2)->nullable()->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_product');
    }
};
