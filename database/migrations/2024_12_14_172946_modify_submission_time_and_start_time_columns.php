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
        Schema::table('users_online_exam_answer', function (Blueprint $table) {
            $table->dateTime('submission_time')->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_online_exam_answer', function (Blueprint $table) {
            $table->time('submission_time')->change();
        });
    }
};
