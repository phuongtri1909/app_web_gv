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
        Schema::table('program_overview', function (Blueprint $table) {
            $table->text('long_description')->nullable()->change();
            $table->string('img_program')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_overview', function (Blueprint $table) {
            $table->text('long_description')->nullable(false)->change();
            $table->string('img_program')->nullable(false)->change();
        });
    }
};
