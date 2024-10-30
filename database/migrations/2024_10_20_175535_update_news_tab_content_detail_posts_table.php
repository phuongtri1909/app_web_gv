<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNewsTabContentDetailPostsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('news_tab_content_detail_posts', function (Blueprint $table) {
           
            $table->dropForeign(['news_id']);
            $table->dropColumn('news_id');
            
            $table->foreignId('financial_support_id')->constrained('financial_support')->onDelete('cascade');
            $table->foreignId('bank_service_id')->nullable()->constrained('bank_services_interest')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_tab_content_detail_posts', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained('news')->onDelete('cascade');
            $table->dropForeign(['financial_support_id']);
            $table->dropColumn('financial_support_id');

            $table->dropForeign(['bank_service_id']);
            $table->dropColumn('bank_service_id');
        });
    }
}
