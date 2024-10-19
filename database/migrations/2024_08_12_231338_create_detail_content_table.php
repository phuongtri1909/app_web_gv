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
        Schema::create('detail_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->string('title');
            $table->text('content');
            $table->string('img_detail');
            $table->string('tag')->nullable();
            $table->enum('key_components',['cp1', 'cp2','cp3']);
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('program_overview')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_content');
    }
};
