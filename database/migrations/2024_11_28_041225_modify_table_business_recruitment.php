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
        Schema::table('business_recruitment', function (Blueprint $table) {
            $table->dropColumn('business_name');
            $table->dropColumn('business_code');
            $table->dropColumn('category_business_id');
            $table->dropColumn('head_office_address');
            $table->dropColumn('phone');
            $table->dropColumn('fax');
            $table->dropColumn('email');
            $table->dropColumn('representative_name');
            $table->dropColumn('gender');
            $table->dropColumn('recruitment_info');

            $table->unsignedBigInteger('business_member_id')->foreign('business_member_id')->references('id')->on('business_registrations');
            $table->text('recruitment_images');
            $table->string('recruitment_title');
            $table->text('recruitment_content');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_recruitment', function (Blueprint $table) {
            $table->string('business_name');
            $table->string('business_code');
            $table->unsignedBigInteger('category_business_id')->foreign('category_business_id')->references('id')->on('category_business');
            $table->string('head_office_address');
            $table->string('phone');
            $table->string('fax');
            $table->string('email');
            $table->string('representative_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->text('recruitment_info');

            $table->dropForeign('business_member_id');
            $table->dropColumn('business_member_id');
            $table->dropColumn('recruitment_images');
            $table->dropColumn('recruitment_title');
            $table->dropColumn('recruitment_content');

        });
    }
};
