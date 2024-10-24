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
        Schema::create('business_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('business_name'); // Tên doanh nghiệp
            $table->string('business_license_number'); // Giấy chứng nhận ĐKKD số
            $table->date('license_issue_date'); // Ngày cấp
            $table->string('license_issue_place'); // Nơi cấp
            $table->string('business_field'); // Lĩnh vực hoạt động
            $table->string('head_office_address'); // Địa chỉ trụ sở chính
            $table->string('phone'); // Điện thoại
            $table->string('fax')->nullable(); // Fax
            $table->string('email'); // Email
            $table->string('branch_address')->nullable(); // Địa chỉ chi nhánh
            $table->string('organization_participation')->nullable(); // Đã tham gia tổ chức
            $table->string('representative_full_name'); // Họ và tên người đại diện
            $table->string('representative_position'); // Chức vụ
            $table->string('gender'); // Giới tính
            $table->string('identity_card'); // CCCD
            $table->date('identity_card_issue_date'); // Ngày cấp CCCD
            $table->string('home_address'); // Địa chỉ nhà riêng
            $table->string('contact_phone'); // Điện thoại liên hệ
            $table->string('representative_email'); // Email người đại diện
            $table->string('business_license_file'); // Giấy CNĐKKD
            $table->string('identity_card_front_file'); // CCCD mặt trước
            $table->string('identity_card_back_file'); // CCCD mặt sau
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_registrations');
    }
};
