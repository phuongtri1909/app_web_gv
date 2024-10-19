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
        Schema::table('sliders', function (Blueprint $table) {
            $table->json('slider_title')->change();
            $table->json('title')->change();
            $table->json('subtitle')->change();
            $table->json('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('slider_title')->change();
            $table->string('title')->change();
            $table->string('subtitle')->change();
            $table->text('description')->change(); 
        });
    }
};
