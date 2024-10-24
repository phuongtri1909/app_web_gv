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
        Schema::create('business_feedback', function (Blueprint $table) {
            $table->id();
            $table->text('opinion');
            $table->text('suggestions')->nullable();
            $table->string('owner_full_name');
            $table->year('birth_year');
            $table->string('gender');
            $table->string('phone');
            $table->string('residential_address');
            $table->string('business_name');
            $table->string('business_address');
            $table->string('email');
            $table->string('fanpage')->nullable();
            $table->string('business_license');
            $table->json('attached_images');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_feedback');
    }
};
