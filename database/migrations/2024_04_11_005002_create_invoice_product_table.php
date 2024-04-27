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
        Schema::create('invoice_product', function (Blueprint $table) {
            $table->foreignId('invoice_id');
            $table->string('product_name')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->decimal('unit_price', 12, 2)->nullable()->default(0.00);
            $table->integer('tax')->nullable()->default(0);
            $table->integer('discount')->nullable()->default(0);
            $table->decimal('total_price', 12, 2)->nullable()->default(0.00);

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
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
