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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('business_code')->unique();
            $table->string('business_name');
            $table->string('representative_name');
            $table->string('phone_number');
            $table->string('fax_number')->nullable();
            $table->string('address');
            $table->unsignedBigInteger('ward_id');
            $table->string('email')->unique();
            $table->unsignedBigInteger('category_business_id');
            $table->string('business_license')->nullable();
            $table->string('social_channel')->nullable();
            $table->text('description')->nullable();
            $table->string('avt_businesses');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // Định nghĩa khóa ngoại
            $table->foreign('ward_id')->references('id')->on('ward_govap')->onDelete('cascade');
            $table->foreign('category_business_id')->references('id')->on('category_business')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
