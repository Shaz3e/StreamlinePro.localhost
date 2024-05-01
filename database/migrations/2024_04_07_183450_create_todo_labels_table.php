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
        Schema::create('todo_labels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('text_color')->nullable()->default('#000000');
            $table->string('bg_color')->nullable()->default('#ffffff');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_statuses');
    }
};
