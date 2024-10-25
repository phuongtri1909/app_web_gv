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
        Schema::create('business_connect_supply_demand', function (Blueprint $table) {
            $table->id();
            $table->string('owner_full_name');
            $table->year('birth_year');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('residential_address');
            $table->string('business_address');
            $table->string('phone');
            $table->string('business_code');
            $table->string('business_name');
            $table->string('business_field');
            $table->string('email');
            $table->string('fanpage')->nullable();
            $table->text('product_info');
            $table->text('product_standard');
            $table->string('product_avatar');
            $table->longText('product_images')->nullable();
            $table->decimal('product_price', 15, 2);
            $table->decimal('product_price_mini_app', 15, 2);
            $table->decimal('product_price_member', 15, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])
            ->default('Đang chờ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_connect_supply_demand');
    }
};
