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
        Schema::table('tabs', function (Blueprint $table) {
            $table->json('title')->change();
        });

        Schema::table('tabs_img_contents', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('content')->change();
        });

        Schema::table('tabs_drop', function (Blueprint $table) {
            $table->json('content')->change();
        });

        Schema::table('tabs_projects', function (Blueprint $table) {
            $table->json('project_name')->change();
        });

        Schema::table('tabs_custom', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tabs', function (Blueprint $table) {
            $table->string('title')->change();
        });

        Schema::table('tabs_img_contents', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('content')->change();
        });

        Schema::table('tabs_drop', function (Blueprint $table) {
            $table->text('content')->change();
        });

        Schema::table('tabs_projects', function (Blueprint $table) {
            $table->string('project_name')->change();
        });

        Schema::table('tabs_custom', function (Blueprint $table) {
            $table->string('title')->change();
            $table->string('description')->change();
        });
    }
};
