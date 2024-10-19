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
        Schema::create('program_overview', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('title_program');
            $table->text('short_description')->nullable();
            $table->text('long_description');
            $table->string('img_program');
            $table->timestamps();
        
            // Định nghĩa khóa ngoại
            $table->foreign('category_id')->references('id')->on('categories_program')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_overview');
    }
};
