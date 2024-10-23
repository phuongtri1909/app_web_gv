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
        Schema::create('business_recruitment', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('business_code');
            $table->foreignId('category_business_id')->constrained('category_business');
            $table->string('head_office_address');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('email');
            $table->string('representative_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->text('recruitment_info');
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])->default('Đang chờ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_recruitment');
    }
};
