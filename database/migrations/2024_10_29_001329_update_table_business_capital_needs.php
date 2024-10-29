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
            $table->unsignedBigInteger('financial_support_id')->nullable();
            $table->unsignedBigInteger('bank_service_id')->nullable();

            $table->foreign('financial_support_id')
                  ->references('id')
                  ->on('financial_supports')
                  ->onDelete('cascade');

            $table->foreign('bank_service_id')
                  ->references('id')
                  ->on('bank_services')
                  ->onDelete('cascade');

            $table->enum('status', ['pending', 'approved', 'rejected'])
                    ->default('pending')
                    ->change();

        });
    }

    public function down(): void
    {
        Schema::table('business_capital_needs', function (Blueprint $table) {
            $table->dropForeign(['financial_support_id']);
            $table->dropForeign(['bank_service_id']);
            $table->dropColumn(['financial_support_id', 'bank_service_id']);
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
            ->default('Đang chờ')
            ->change();
        });
    }
};
