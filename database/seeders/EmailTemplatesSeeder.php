<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('email_templates')->insert([
            [
                'name' => 'bank',
                'content' => '<p>Kính gửi Ngân hàng <strong>{{ bank_name }}</strong>,</p>

<p>
    Doanh nghiệp {{ business_name }} (Mã số doanh nghiệp: {{ business_code }}) có nhu cầu vay vốn với các thông tin chi tiết như sau:
</p>

<div class="container">
    <div class="content">
        <div class="info-list">
            <div class="info-item">
                <strong>Số vốn đăng ký:</strong> {{ finance }} đ
            </div>
            <div class="info-item">
                <strong>Chu kỳ vay:</strong> {{ loan_cycle }} tháng
            </div>
            <div class="info-item">
                <strong>Lãi suất đề xuất:</strong> {{ interest_rate }}%
            </div>
            <div class="info-item">
                <strong>Mục đích vay vốn:</strong> {{ purpose }}
            </div>
            <div class="info-item">
                <strong>Ngân hàng kết nối:</strong> {{ bank_connection }}
            </div>
            <div class="info-item">
                <strong>Chính sách hỗ trợ:</strong> {{ support_policy }}
            </div>
            <div class="info-item">
                <strong>Phản hồi:</strong> {{ feedback }}
            </div>
            <div class="info-item">
                <strong>Thông tin liên hệ:</strong>
            </div>
            <div class="info-item">
                - <strong>Đại diện:</strong> {{ representative_full_name }}
            </div>
            <div class="info-item">
                - <strong>Số điện thoại:</strong> {{ representative_phone }}
            </div>
            <div class="info-item">
                - <strong>Địa chỉ:</strong> {{ address }}
            </div>
        </div>
    </div>
</div>

<hr />

<p>
    Chúng tôi rất mong nhận được sự hỗ trợ từ quý ngân hàng. Nếu cần thêm thông tin hoặc tài liệu, xin vui lòng liên hệ với chúng tôi qua email này hoặc thông qua tài khoản doanh nghiệp đã đăng ký.
</p>

<p>Trân trọng cảm ơn!</p>

<hr />

<p>
    <em>Email được gửi tự động từ </em>Gò Vấp E-Business.
</p>
',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ncb',
                'content' => '<div class="container">
<div class="content">
<div class="info-list">
<div class="info-item">Doanh nghiệp {{ business_name }} (M&atilde; số doanh nghiệp: {{ business_code }}) c&oacute; nhu cầu vay vốn với c&aacute;c th&ocirc;ng tin chi tiết như sau:</div>

<div class="info-item"><strong>Số vốn đăng ký:</strong> {{ finance }} đ</div>

<div class="info-item"><strong>Chu kỳ vay:</strong> {{ loan_cycle }} th&aacute;ng</div>

<div class="info-item"><strong>Lãi suất đề xuất:</strong> {{ interest_rate }}%</div>

<div class="info-item"><strong>Mục đích vay vốn:</strong> {{ purpose }}</div>

<div class="info-item"><strong>Ngân hàng kết nối:</strong> {{ bank_connection }}</div>

<div class="info-item"><strong>Chính sách hỗ trợ:</strong> {{ support_policy }}</div>

<div class="info-item"><strong>Phản hồi:</strong> {{ feedback }}</div>

<div class="info-item">
<p>Thông tin liên hệ:</p>

<p>- <strong>Đại diện:</strong> {{ representative_full_name }}</p>

<p>- <strong>Số điện thoại:</strong> {{ representative_phone }}</p>

<p>- <strong>Địa chỉ: </strong>{{ address }}</p>
</div>
</div>
</div>
</div>

',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
