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
        Schema::table('customer_interest', function (Blueprint $table) {
            $table->foreignId('bank_service_id')->nullable()->after('support_needs')->constrained('bank_services_interest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_interest', function (Blueprint $table) {
            $table->dropForeign(['bank_service_id']);
            $table->dropColumn('bank_service_id');
        });
    }
};
