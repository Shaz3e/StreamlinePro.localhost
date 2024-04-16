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
        Schema::create('support_ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_ticket_id')->nullable();
            $table->foreign('support_ticket_id')->references('id')->on('support_tickets')->onDelete('set null');

            $table->foreignId('client_reply_by')->nullable();
            $table->foreign('client_reply_by')->references('id')->on('users')->onDelete('set null');

            $table->foreignId('staff_reply_by')->nullable();
            $table->foreign('staff_reply_by')->references('id')->on('admins')->onDelete('set null');

            $table->longText('message');
            $table->text('attachments')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('support_ticket_replies', function (Blueprint $table) {
            // drop foreign index
            $table->dropForeign('support_ticket_replies_support_ticket_id_foreign');
            $table->dropForeign('support_ticket_replies_client_reply_by_foreign');
            $table->dropForeign('support_ticket_replies_staff_reply_by_foreign');
            // drop column
            $table->dropColumn('support_ticket_id');
            $table->dropColumn('client_reply_by');
            $table->dropColumn('staff_reply_by');
        });
        Schema::dropIfExists('support_ticket_replies');
    }
};
