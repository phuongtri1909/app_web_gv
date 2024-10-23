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
        Schema::create('business_start_promotion_investment', function (Blueprint $table) {
            $table->id();
            $table->string('representative_name');
            $table->year('birth_year');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('phone');
            $table->string('address');
            $table->string('business_address');
            $table->string('business_name');
            $table->string('business_code');
            $table->string('business_field');
            $table->string('email');
            $table->string('fanpage')->nullable();
            $table->unsignedBigInteger('business_support_needs_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_start_promotion_investment');
    }
};
