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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->enum('age', ['1','1-2','2-3','3-4','4-5','5-6'])->default('1');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->text('content')->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
