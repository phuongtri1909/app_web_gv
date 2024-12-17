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
            $table->dropForeign(['users_online_exam_id']);
            $table->dropColumn('users_online_exam_id');

            $table->unsignedBigInteger('customer_id')->after('id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_online_exam_answer', function (Blueprint $table) {

            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');

            $table->unsignedBigInteger('users_online_exam_id');
            $table->foreign('users_online_exam_id')
                  ->references('id')->on('users_online_exams')
                  ->onDelete('cascade');

            
        });
    }
};
