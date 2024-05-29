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

            // Assign User an invoice
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Assign Company an invoice
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Assign Invoice Label
            $table->foreignId('invoice_label_id')->nullable();
            $table->foreign('invoice_label_id')->references('id')->on('invoice_labels')->onDelete('cascade');
            
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();

            // Invoice Status
            $table->string('status')->default('Unpaid');

            $table->boolean('is_published')->default(false);
            $table->date('published_on')->default(now());

            // Store special notes for this invoice
            $table->text('header_note')->nullable();
            $table->text('footer_note')->nullable();
            $table->text('private_note')->nullable();
            $table->text('cancel_note')->nullable();

            $table->string('discount_type')->nullable();
            
            $table->decimal('sub_total', 65, 2)->nullable()->default(0.00);
            $table->decimal('discount', 65, 2)->nullable()->default(0.00);
            $table->decimal('tax', 65, 2)->nullable()->default(0.00);
            $table->decimal('total', 65, 2)->nullable()->default(0.00);
            $table->decimal('total_paid', 65, 2)->nullable()->default(0.00);
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
