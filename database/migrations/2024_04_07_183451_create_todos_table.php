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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('todo_status_id')
                ->nullable();
            $table->foreign('todo_status_id')
                ->references('id')
                ->on('todo_statuses')
                ->onDelete('set null');

            $table->foreignId('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');

            $table->string('title');
            $table->longText('todo_details');
            $table->dateTime('reminder')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->dateTime('closed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropForeign('todos_todo_status_id_foreign');
            $table->dropForeign('todos_admin_id_foreign');
        });
        Schema::dropIfExists('todos');
    }
};
