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
        Schema::table('business_feedback', function (Blueprint $table) {
            $table->dropColumn([
                'suggestions',
                'owner_full_name',
                'birth_year',
                'gender',
                'phone',
                'residential_address',
                'business_name',
                'business_address',
                'email',
                'fanpage',
                'business_license',
            ]);
            $table->unsignedBigInteger('business_member_id')->nullable();

            $table->foreign('business_member_id')
                  ->references('id')
                  ->on('business_registrations')
                  ->onDelete('set null')->after('attached_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_feedback', function (Blueprint $table) {
            $table->text('suggestions')->nullable();
            $table->string('owner_full_name', 255);
            $table->year('birth_year');
            $table->string('gender', 255);
            $table->string('phone', 255);
            $table->string('residential_address', 255);
            $table->string('business_name', 255);
            $table->string('business_address', 255);
            $table->string('email', 255)->nullable();
            $table->string('fanpage', 255)->nullable();
            $table->string('business_license', 255);
            $table->dropForeign(['business_member_id']);
            $table->dropColumn('business_member_id');
        });
    }
};
