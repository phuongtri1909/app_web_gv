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
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('birth_year');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('business_address');
            $table->unsignedBigInteger('category_business_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('birth_year');
            $table->dropColumn('gender');
            $table->dropColumn('business_address');
            $table->unsignedBigInteger('category_business_id')->nullable(false)->change();
        });
    }
};
