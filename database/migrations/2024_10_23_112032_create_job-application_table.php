<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('job_application', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('birth_year');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('email');
            $table->text('introduction');
            $table->text('job_registration');
            $table->enum('status', ['Đang chờ', 'Phê duyệt', 'Từ chối'])->default('Đang chờ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_application');
    }
};
