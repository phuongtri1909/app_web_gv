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
        Schema::create('content_tuitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tuition_id')->constrained()->onDelete('cascade');
            $table->text('list');
            $table->text('cost');
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_tuitions');
    }
};
