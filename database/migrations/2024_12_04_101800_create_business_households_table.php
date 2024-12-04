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
        Schema::create('business_households', function (Blueprint $table) {
            $table->id();
            $table->string('license_number');
            $table->date('date_issued');
            $table->string('business_owner_full_name');
            $table->string('business_dob');
            $table->string('house_number');
            $table->unsignedBigInteger('road_id');
            $table->foreign('road_id')->references('id')->on('roads');
            $table->string('signboard')->nullable();
            $table->text('business_field');
            $table->string('phone')->nullable();
            $table->string('cccd');
            $table->string('address');
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_households');
    }
};
