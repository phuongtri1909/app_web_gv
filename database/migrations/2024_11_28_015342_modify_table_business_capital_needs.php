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

        

        Schema::table('business_capital_needs', function (Blueprint $table) {

            $table->dropForeign(['business_id']);
            $table->dropForeign(['financial_support_id']);
            $table->dropForeign(['bank_services_interest_id']);

            $table->dropColumn('business_id');
            $table->dropColumn('financial_support_id');
            $table->dropColumn('bank_services_interest_id');
            $table->dropColumn('mortgage_policy');
            $table->dropColumn('unsecured_policy');

            $table->unsignedBigInteger('business_member_id')->foreign('business_member_id')->references('id')->on('business_registrations');
            $table->integer('loan_cycle');
            $table->text('support_policy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_capital_needs', function (Blueprint $table) {
            $table->dropForeign(['business_member_id']);
            $table->dropColumn('business_member_id');
            $table->dropColumn('loan_cycle');
            $table->dropColumn('support_policy');

            $table->unsignedBigInteger('business_id')->foreign('business_id')->references('id')->on('business_registrations');
            $table->unsignedBigInteger('financial_support_id')->foreign('financial_support_id')->references('id')->on('financial_supports')->nullable();
            $table->unsignedBigInteger('bank_services_interest_id')->foreign('bank_services_interest_id')->references('id')->on('bank_services_interests')->nullable();
            $table->text('mortgage_policy');
            $table->text('unsecured_policy');
        });
    }
};
