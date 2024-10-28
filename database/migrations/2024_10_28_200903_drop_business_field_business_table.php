<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('business_field_business');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('business_field_business', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_field_id');
            $table->unsignedBigInteger('business_id');
            $table->timestamps();
        });
    }
};
