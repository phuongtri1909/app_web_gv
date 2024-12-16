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
        Schema::create('users_online_exam_answer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_online_exam_id');
            $table->unsignedBigInteger('question_id');
            $table->string('status');
            $table->time('submission_time');
            $table->dateTime('start_time');
            $table->timestamps();

            $table->foreign('users_online_exam_id')
                  ->references('id')->on('users_online_exams')
                  ->onDelete('cascade');
            $table->foreign('question_id')
                  ->references('id')->on('questions')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_online_exam_answer');
    }
};
