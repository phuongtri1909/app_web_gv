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
        Schema::create('tabs_drop', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tab_id')->constrained('tabs')->onDelete('cascade');
            $table->string('image');
            $table->text('content');
            $table->string('icon')->nullable();
            $table->string('bg_color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabs_drop');
    }
};
