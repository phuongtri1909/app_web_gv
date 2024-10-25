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
        Schema::table('news_tab_content_detail_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('financial_support_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_tab_content_detail_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('financial_support_id')->change();
        });
    }
};
