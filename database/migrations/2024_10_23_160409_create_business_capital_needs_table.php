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
        Schema::create('business_capital_needs', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('business_code');
            $table->unsignedBigInteger('category_business_id');
            $table->string('address');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('email');
            $table->string('representative_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->decimal('interest_rate', 15, 2);
            $table->decimal('finance', 15, 2);
            $table->text('mortgage_policy');
            $table->text('unsecured_policy');
            $table->text('purpose');
            $table->string('bank_connection');
            $table->text('feedback')->nullable();
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])->default('Đang chờ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_capital_needs');
    }
};
