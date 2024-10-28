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
        Schema::table('product_businesses', function (Blueprint $table) {
            $table->bigInteger('price_mini_app');
            $table->bigInteger('price_member');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
            ->default('Đang chờ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_businesses', function (Blueprint $table) {
            $table->dropColumn('price_mini_app');
            $table->dropColumn('price_member');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('status');
        });
    }
};
