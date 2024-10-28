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
        Schema::table('business_feedback', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->change();
        });

        Schema::table('business_start_promotion_investment', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->change();
        });

        Schema::table('job_application', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->change();
        });

        Schema::table('business_recruitment', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_feedback', function (Blueprint $table) {
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
                ->default('Đang chờ')
                ->change();
        });

        Schema::table('business_start_promotion_investment', function (Blueprint $table) {
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
                ->default('Đang chờ')
                ->change();
        });

        Schema::table('job_application', function (Blueprint $table) {
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
                ->default('Đang chờ')
                ->change();
        });

        Schema::table('business_recruitment', function (Blueprint $table) {
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
                ->default('Đang chờ')
                ->change();
        });
    }
};
