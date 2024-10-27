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
        Schema::table('business_capital_needs', function (Blueprint $table) {
            $table->dropColumn('business_name');
            $table->dropColumn('business_code');
            $table->dropColumn('address');
            $table->dropColumn('phone');
            $table->dropColumn('fax');
            $table->dropColumn('email');
            $table->dropColumn('representative_name');
            $table->dropColumn('gender');

            if (!Schema::hasColumn('business_capital_needs', 'business_id')) {
                $table->foreignId('business_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            }
            if (Schema::hasColumn('business_capital_needs', 'category_business_id')) {
                $table->dropColumn('category_business_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_capital_needs', function (Blueprint $table) {
            $table->string('business_name');
            $table->string('business_code');
            $table->string('address');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('email');
            $table->string('representative_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->unsignedBigInteger('category_business_id')->after('id');
        });
    }
};
