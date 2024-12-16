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
        Schema::create('users_online_exams', function (Blueprint $table) {
            $table->id('id');
            $table->string('identity_card_number')->nullable();
            $table->string('full_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedBigInteger('wards_id')->nullable();
            $table->string('street_number')->nullable();
            $table->timestamps();

            $table->foreign('wards_id')
                  ->references('id')->on('ward_govap')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_online_exams');
    }
};
