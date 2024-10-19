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
        Schema::create('categories_program', function (Blueprint $table) {
            $table->id();
            $table->enum('key_page',['page_home','page_program','key_cb2']);
            $table->string('name_category')->nullable();
            $table->text('desc_category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_program');
    }
};
