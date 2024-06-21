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
        Schema::create('bulk_emails', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->longText('content')->nullable();
            $table->json('user_id')->nullable();
            $table->json('admin_id')->nullable();
            $table->dateTime('send_date')->nullable();
            $table->boolean('is_publish')->default(false);
            $table->boolean('is_sent')->default(false);
            $table->boolean('is_sent_all_users')->default(false);
            $table->boolean('is_sent_all_admins')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_emails');
    }
};
