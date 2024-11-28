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
        Schema::create('business_fair_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreign('business_member_id')->references('id')->on('business_registrations')->onDelete('cascade');
            $table->unsignedBigInteger('business_member_id');
            $table->string('business_license')->nullable();
            $table->string('representative_full_name');
            $table->integer('birth_year');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('phone_zalo');
            $table->text('products');
            $table->text('product_images');
            $table->enum('booth_count',[1,2])->default(1);
            $table->decimal('discount_percentage', 5, 2)->nullable()->default(0);
            $table->tinyInteger('is_join_stage_promotion')->default(0);
            $table->tinyInteger('is_join_charity')->default(0);            
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->unsignedBigInteger('news_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_fair_registrations');
    }
};
