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
        Schema::table('about_us', function (Blueprint $table) {
            $table->json('title_about')->change();
            $table->json('subtitle_about')->change();
            $table->json('title_detail')->change();
            $table->json('subtitle_detail')->change();
            $table->json('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->string('title_about')->change();
            $table->string('subtitle_about')->change();
            $table->string('title_detail')->change();
            $table->string('subtitle_detail')->change();
            $table->string('description')->change();
        });
    }
};
