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
        Schema::table('ward_detail', function (Blueprint $table) {
            $table->decimal('area', 10, 3)->change();
        });
        Schema::table('districts_govap', function (Blueprint $table) {
            $table->decimal('area', 10, 3)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ward_detail', function (Blueprint $table) {
            $table->decimal('area', 10, 2)->change();
        });
        Schema::table('districts_govap', function (Blueprint $table) {
            $table->decimal('area', 10, 2)->change();
        });
    }
};
