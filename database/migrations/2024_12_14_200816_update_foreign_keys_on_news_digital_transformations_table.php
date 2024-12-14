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
        Schema::table('news_digital_transformations', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['news_id']);
            $table->dropForeign(['digital_transformation_id']);

            // Add foreign keys with onDelete('cascade')
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->foreign('digital_transformation_id')->references('id')->on('digital_transformations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_digital_transformations', function (Blueprint $table) {
            // Drop foreign keys with onDelete('cascade')
            $table->dropForeign(['news_id']);
            $table->dropForeign(['digital_transformation_id']);

            // Add original foreign keys
            $table->foreign('news_id')->references('id')->on('news');
            $table->foreign('digital_transformation_id')->references('id')->on('digital_transformations');
        });
    }
};
