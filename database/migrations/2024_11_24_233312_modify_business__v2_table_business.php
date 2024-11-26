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

         // Drop foreign key constraints using raw SQL
         DB::statement('ALTER TABLE businesses DROP FOREIGN KEY businesses_ward_id_foreign');
         DB::statement('ALTER TABLE businesses DROP FOREIGN KEY businesses_category_business_id_foreign');
         DB::statement('ALTER TABLE businesses DROP FOREIGN KEY businesses_business_fields_foreign');
        Schema::table('businesses', function (Blueprint $table) {
          
            $table->string('avt_businesses')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();

           // Drop columns
           $table->dropColumn([
               'business_code',
               'business_name',
               'representative_name',
               'phone_number',
               'fax_number',
               'address',
               'ward_id',
               'email',
               'category_business_id',
               'business_license',
               'social_channel',
               'birth_year',
               'gender',
               'business_address',
               'business_fields',
           ]);

            $table->unsignedBigInteger('business_member_id')->nullable();

           
        });

      
         DB::statement('UPDATE businesses SET business_member_id = id');

     
         Schema::table('businesses', function (Blueprint $table) {
             $table->unsignedBigInteger('business_member_id')->nullable(false)->change();
             $table->foreign('business_member_id')->references('id')->on('business_registrations')->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        DB::statement('ALTER TABLE businesses DROP FOREIGN KEY businesses_business_member_id_foreign');
        Schema::table('businesses', function (Blueprint $table) {

           
            $table->dropColumn('business_member_id');

            // Add columns back
            $table->string('business_code')->nullable();
            $table->string('business_name')->nullable();
            $table->string('representative_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('category_business_id')->nullable();
            $table->string('business_license')->nullable();
            $table->string('social_channel')->nullable();
            $table->integer('birth_year')->nullable();
            $table->string('gender')->nullable();
            $table->string('business_address')->nullable();
            $table->unsignedBigInteger('business_fields')->nullable();

            $table->foreign('ward_id')->references('id')->on('ward_govap')->onDelete('set null');
            $table->foreign('category_business_id')->references('id')->on('category_business')->onDelete('set null');
            $table->foreign('business_fields')->references('id')->on('business_fields')->onDelete('set null');
        });
    }
};
