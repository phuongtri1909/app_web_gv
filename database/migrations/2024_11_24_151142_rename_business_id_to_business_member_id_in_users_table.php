<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void

    {
        // Thêm cột mới
         Schema::table('users', function (Blueprint $table) {
             $table->unsignedBigInteger('business_member_id')->nullable();
         });
        
        // // Copy dữ liệu từ business_id sang business_member_id
         DB::statement('UPDATE users SET business_member_id = business_id');

        DB::statement('ALTER TABLE `users` DROP FOREIGN KEY IF EXISTS `users_business_id_foreign`');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('business_id');
            // Thêm khóa ngoại mới
            $table->foreign('business_member_id')->references('id')->on('business_registrations')->onDelete('set null');
        }); 
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('business_id')->nullable();
        });

       
        DB::statement('UPDATE users SET business_id = business_member_id');

        
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['business_member_id']);
            $table->dropColumn('business_member_id');

            // Thêm lại khóa ngoại cũ
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('set null');
        });
    }
};
