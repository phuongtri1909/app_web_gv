<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('business_feedback', function (Blueprint $table) {
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
                  ->default('Đang chờ')
                  ->after('attached_images');
        });

        Schema::table('business_start_promotion_investment', function (Blueprint $table) {
         

            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
                  ->default('Đang chờ')
                  ->after('business_support_needs_id');

        });

        Schema::table('business_promotional_introduction', function (Blueprint $table) {
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
                  ->default('Đang chờ')
                  ->after('product_video');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('business_feedback', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('business_start_promotion_investment', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('business_promotional_introduction', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
