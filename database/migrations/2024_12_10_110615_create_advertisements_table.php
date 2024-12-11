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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('ad_title');
            $table->string('slug');
            $table->longText('ad_description')->nullable();
            $table->string('ad_price')->nullable();
            $table->string('ad_full_name');
            $table->string('ad_contact_phone');
            $table->string('ad_cccd')->nullable();
            $table->foreignId('category_id')->constrained('ad_categories')->onDelete('cascade');
            $table->foreignId('type_id')->constrained('ad_types')->onDelete('cascade');
            $table->foreignId('road_id')->constrained('roads')->onDelete('cascade');
            $table->date('ad_start_date')->nullable();
            $table->date('ad_end_date')->nullable();
            $table->enum('ad_status', ['active', 'inactive', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
