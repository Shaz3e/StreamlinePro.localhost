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
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->foreignId('support_ticket_priority_id')->nullable()->after('support_ticket_status_id');
            $table->foreign('support_ticket_priority_id')->references('id')->on('support_ticket_priorities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            // remove foreign index
            $table->dropForeign('support_tickets_support_ticket_priority_id_foreign');
            // drop support_ticket_priority_id
            $table->dropColumn('support_ticket_priority_id');
        });
    }
};
