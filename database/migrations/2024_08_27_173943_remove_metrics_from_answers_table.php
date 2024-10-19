<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn(['view', 'count_answer', 'follow']);
        });
    }

    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->integer('view')->default(0);
            $table->integer('count_answer')->default(0);
            $table->integer('follow')->default(0);
        });
    }

};
