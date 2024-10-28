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
        Schema::dropIfExists('business_promotional_introduction');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('business_promotional_introduction', function (Blueprint $table) {
            $table->id();
            $table->string('representative_name');
            $table->string('birth_year');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('phone_number');
            $table->string('address');
            $table->string('business_address');
            $table->string('business_name');
            $table->string('license');
            $table->string('business_code');
            $table->string('email');
            $table->string('social_channel')->nullable();
            $table->string('logo');
            $table->longText('product_image')->nullable();
            $table->longText('product_video')->nullable();
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
            ->default('Đang chờ');
            $table->timestamps();

        });
    }
};
