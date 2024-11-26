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
        Schema::table('business_registrations', function (Blueprint $table) {
             // Thêm các cột mới
             $table->string('business_code')->after('business_name');
             $table->text('address')->after('business_code');
             $table->string('representative_phone')->after('representative_full_name');
             
             $table->string('phone_zalo')->after('email');

             // Thêm cột business_field_id để thiết lập quan hệ
            $table->unsignedBigInteger('business_field_id')->nullable()->after('phone_zalo');

            // Thiết lập khóa ngoại cho cột business_field_id
            $table->foreign('business_field_id')->references('id')->on('business_fields')->onDelete('set null');
            
            $table->dropColumn([
                'business_field',
                'business_license_number',
                'license_issue_date',
                'license_issue_place',
                'head_office_address',
                'fax',
                'branch_address',
                'organization_participation',
                'representative_position',
                'gender',
                'identity_card',
                'identity_card_issue_date',
                'home_address',
                'contact_phone',
                'representative_email',
                'business_license_file',
                'identity_card_front_file',
                'identity_card_back_file',
                'phone',
            ]);
        });
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_registrations', function (Blueprint $table) {
            
            $table->dropColumn([
                'business_code',
                'address',
                'representative_phone',
                'phone_zalo',
                'business_field_id',
            ]);

            $table->string('business_field');

            $table->renameColumn('phone_zalo', 'phone');

            $table->string('business_license_number');
            $table->date('license_issue_date');
            $table->string('license_issue_place');
            $table->string('head_office_address');
            $table->string('fax')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('organization_participation')->nullable();
            $table->string('representative_position');
            $table->string('gender');
            $table->string('identity_card');
            $table->date('identity_card_issue_date');
            $table->string('home_address');
            $table->string('contact_phone');
            $table->string('representative_email');
            $table->string('business_license_file');
            $table->string('identity_card_front_file');
            $table->string('identity_card_back_file');
            $table->string('phone');
        });
    }
};
