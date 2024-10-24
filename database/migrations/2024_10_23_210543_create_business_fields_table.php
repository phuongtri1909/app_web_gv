<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('business_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });


        DB::table('business_fields')->insert([
            ['name' => 'Ẩm thực'],
            ['name' => 'Nhà hàng'],
            ['name' => 'Khách sạn'],
            ['name' => 'Du lịch'],
            ['name' => 'Thể thao'],
            ['name' => 'Sản xuất'],
            ['name' => 'Thương mại'],
            ['name' => 'Thời trang'],
            ['name' => 'Điện máy'],
            ['name' => 'Công nghệ'],
            ['name' => 'Y tế'],
            ['name' => 'Giáo dục'],
            ['name' => 'Khác'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_fields');
    }
};
