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
        Schema::table('location_products', function (Blueprint $table) {
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
            ->default('Đang chờ')->after('media_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('location_products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};