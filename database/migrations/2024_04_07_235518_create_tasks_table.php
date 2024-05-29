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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_label_id')->nullable();
            $table->foreign('task_label_id')->references('id')->on('task_labels')->onDelete('set null');

            $table->foreignId('assigned_to')->nullable();
            $table->foreign('assigned_to')->references('id')->on('admins')->onDelete('set null');

            $table->string('title');
            $table->longText('description')->nullable();

            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');

            $table->boolean('is_started')->default(false);
            $table->dateTime('start_time')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->dateTime('complete_time')->nullable();
            $table->boolean('is_notification_sent')->default(false);
            $table->dateTime('notification_time')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('tasks_task_status_id_foreign');
            $table->dropForeign('tasks_assigned_to_foreign');
            $table->dropForeign('tasks_created_by_foreign');
        });
        Schema::dropIfExists('tasks');
    }
};
