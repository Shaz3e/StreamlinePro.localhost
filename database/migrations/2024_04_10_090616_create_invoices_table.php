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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // Assign Company a invoice
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Assign Invoice Status
            $table->foreignId('invoice_status_id')->nullable();
            $table->foreign('invoice_status_id')->references('id')->on('invoice_statuses')->onDelete('cascade');
            
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();

            $table->decimal('total_tax', 12, 2)->nullable()->default(0.00);
            $table->decimal('total_price', 12, 2)->nullable()->default(0.00);
            $table->decimal('total_discount', 12, 2)->nullable()->default(0.00);
            $table->decimal('total_amount', 12, 2)->nullable()->default(0.00);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('company_id');
            $table->dropForeign('invoice_status_id');
        });
        Schema::dropIfExists('invoices');
    }
};
