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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bulk_email_id');
            $table->foreign('bulk_email_id')->references('id')->on('bulk_emails')->onDelete('cascade');
            $table->string('email');
            $table->string('subject');
            $table->longText('content');
            $table->dateTime('send_date')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->string('status')->default('Pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
