<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSupportNeedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supportNeeds = [
            ['name' => 'Nghề nghiệp', 'status' => true],
            ['name' => 'Vốn vay', 'status' => true],
            ['name' => 'Văn phòng làm việc', 'status' => true],
            ['name' => 'Địa điểm kinh doanh', 'status' => true],
            ['name' => 'Thủ tục hành chính', 'status' => true],
            ['name' => 'Tư vấn pháp luật', 'status' => true],
            ['name' => 'Tư vấn kinh nghiệm', 'status' => true],
            ['name' => 'Tham gia hội chợ kích cầu, xúc tiến thương mại', 'status' => true],
            ['name' => 'Tìm kiếm đối tác', 'status' => true],
        ];

        DB::table('business_support_needs')->insert($supportNeeds);
    }
}
