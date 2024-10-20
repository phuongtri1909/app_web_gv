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
            if (Schema::hasColumn('news_tab_content_detail_posts', 'news_id')) {
                $table->dropForeign(['news_id']);
                $table->dropColumn('news_id');
            }
            $table->foreignId('financial_support_id')->constrained('financial_support')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_tab_content_detail_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('news_id');
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');

            $table->dropForeign(['financial_support_id']);
            $table->dropColumn('financial_support_id');
        });
    }
}
