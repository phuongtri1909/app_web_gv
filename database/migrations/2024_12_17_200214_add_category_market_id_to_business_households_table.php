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
        Schema::table('business_households', function (Blueprint $table) {
            $table->unsignedBigInteger('category_market_id')->after('road_id')->nullable();

            $table->foreign('category_market_id')->references('id')->on('category_market')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_households', function (Blueprint $table) {
            $table->dropForeign(['category_market_id']);
            $table->dropColumn('category_market_id');
        });
    }
};
