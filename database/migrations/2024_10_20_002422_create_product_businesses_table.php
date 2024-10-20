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
        Schema::create('product_businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_product_id')->constrained('category_product_businesses')->cascadeOnDelete();
            $table->string('name_product');
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2);
            $table->text('product_story')->nullable();
            $table->string('slug')->unique();
            $table->string('product_avatar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_businesses');
    }
};
