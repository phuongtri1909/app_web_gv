<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('business_capital_needs', function (Blueprint $table) {
            $table->foreignId('financial_support_id')
                ->nullable()
                ->constrained('financial_support')
                ->onDelete('cascade');

            $table->foreignId('bank_services_interest_id')
                ->nullable()
                ->constrained('bank_services_interest')
                ->onDelete('cascade');

            // Change the status column
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->change();
        });
    }

    public function down(): void
    {

        Schema::table('business_capital_needs', function (Blueprint $table) {
            $table->dropForeign(['financial_support_id']);
            $table->dropColumn('financial_support_id');

            $table->dropForeign(['bank_services_interest_id']);
            $table->dropColumn('bank_services_interest_id');

            // Change the status column
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->change();
        });
    }
};
