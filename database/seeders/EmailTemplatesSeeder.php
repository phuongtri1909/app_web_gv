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
                'content' => '<p>K&iacute;nh gửi Ng&acirc;n h&agrave;ng <strong>{{ bank_name }}</strong>,</p>

<p>Doanh nghiệp của ch&uacute;ng t&ocirc;i c&oacute; nhu cầu vay vốn với c&aacute;c th&ocirc;ng tin chi tiết như sau:</p>

<div class="container">
<div class="content">
<div class="info-list">
<div class="info-item"><strong>Số vốn đăng k&yacute;:</strong> {{ finance }} đ</div>

<div class="info-item"><strong>Chu kỳ vay:</strong> {{ loan_cycle }} th&aacute;ng</div>

<div class="info-item"><strong>L&atilde;i suất đề xuất:</strong> {{ interest_rate }}%</div>

<div class="info-item"><strong>Mục đ&iacute;ch vay vốn:</strong> {{ purpose }}</div>

<div class="info-item"><strong>Ng&acirc;n h&agrave;ng kết nối:</strong> {{ bank_connection }}</div>

<div class="info-item"><strong>Ch&iacute;nh s&aacute;ch hỗ trợ:</strong> {{ support_policy }}</div>

<div class="info-item"><strong>Phản hồi:</strong> {{ feedback }}</div>
</div>
</div>
</div>

<p>Ch&uacute;ng t&ocirc;i rất mong nhận được sự hỗ trợ từ qu&yacute; ng&acirc;n h&agrave;ng. Nếu cần th&ecirc;m th&ocirc;ng tin hoặc t&agrave;i liệu, xin vui l&ograve;ng li&ecirc;n hệ với ch&uacute;ng t&ocirc;i qua email n&agrave;y hoặc th&ocirc;ng qua t&agrave;i khoản doanh nghiệp đ&atilde; đăng k&yacute;.</p>

<p>Tr&acirc;n trọng cảm ơn!</p>

<hr />
<p><em>Email được gửi tự động từ </em>G&ograve; Vấp E-Business.</p>
',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ncb',
                'content' => '<div class="container">
<div class="content">
<div class="info-list">
<div class="info-item"><strong>Số vốn đăng k&yacute;:</strong> {{ finance }} đ</div>

<div class="info-item"><strong>Chu kỳ vay:</strong> {{ loan_cycle }} th&aacute;ng</div>

<div class="info-item"><strong>L&atilde;i suất đề xuất:</strong> {{ interest_rate }}%</div>

<div class="info-item"><strong>Mục đ&iacute;ch vay vốn:</strong> {{ purpose }}</div>

<div class="info-item"><strong>Ng&acirc;n h&agrave;ng kết nối:</strong> {{ bank_connection }}</div>

<div class="info-item"><strong>Ch&iacute;nh s&aacute;ch hỗ trợ:</strong> {{ support_policy }}</div>

<div class="info-item"><strong>Phản hồi:</strong> {{ feedback }}</div>
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
