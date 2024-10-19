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
        Schema::create('parents_child_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parents_child_id')->constrained('parents_child')->onDelete('cascade');
            $table->longText('image');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents_child_detail');
    }
};
