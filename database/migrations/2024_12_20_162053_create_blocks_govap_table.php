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
        Schema::create('blocks_govap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('districts_govap_id');
            $table->string('name');
            $table->integer('total_households');
            $table->foreign('districts_govap_id')->references('id')->on('districts_govap')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks_govap');
    }
};
