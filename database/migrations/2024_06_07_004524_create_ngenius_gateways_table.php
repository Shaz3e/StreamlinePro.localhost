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
        Schema::create('ngenius_gateways', function (Blueprint $table) {
            $table->id();
            // merchantOrderReference
            $table->foreignId('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            // orderReference
            $table->string('reference')->unique();
            // outletId
            $table->string('outlet_id');
            // value
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ngenius_gateways');
    }
};
