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
        Schema::create('districts_govap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ward_detail_id');
            $table->string('name');
            $table->decimal('area', 10, 2);
            $table->integer('total_households');
            $table->integer('population');
            $table->string('secretary_name')->nullable();
            $table->string('head_name')->nullable();
            $table->foreign('ward_detail_id')->references('id')->on('ward_detail')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts_govap');
    }
};
