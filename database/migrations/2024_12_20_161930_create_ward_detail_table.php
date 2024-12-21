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
        Schema::create('ward_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ward_govap_id');
            $table->decimal('area', 10, 2);
            $table->integer('total_households');
            $table->foreign('ward_govap_id')->references('id')->on('ward_govap')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ward_detail');
    }
};
