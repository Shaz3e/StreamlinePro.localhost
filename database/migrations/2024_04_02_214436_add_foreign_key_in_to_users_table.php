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
        Schema::table('users', function (Blueprint $table) {
            // add foreignkey nullable after id
            $table->foreignId('company_id')->nullable()->after('id');
            // on delete should be null
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // remove foreign index
            $table->dropForeign('users_company_id_foreign');
            // drop company_id
            $table->dropColumn('company_id');
        });
    }
};
