<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('about_us')->insert([
            'title_about' => json_encode([
                'en' => 'We are pioneers, explorers, storytellers',
                'vi' => 'Chúng tôi là những người tiên phong, nhà thám hiểm, người kể chuyện'
            ]),
            'subtitle_about' => json_encode([
                'en' => 'Artisans of tailormade travel',
                'vi' => 'Nghệ nhân của du lịch tùy chỉnh'
            ]),
            'title_detail' => json_encode([
                'en' => 'On the ground',
                'vi' => 'Trên mặt đất'
            ]),
            'subtitle_detail' => json_encode([
                'en' => 'Experts that you can rely on',
                'vi' => 'Chuyên gia mà bạn có thể tin cậy'
            ]),
            'description' => json_encode([
                'en' => 'Our 700 in-destination team members specialise in trip planning, product development, and everything else needed to ensure that each of our journeys is distinct and memorable.',
                'vi' => '700 thành viên trong đội ngũ của chúng tôi chuyên về lập kế hoạch chuyến đi, phát triển sản phẩm và mọi thứ khác cần thiết để đảm bảo rằng mỗi hành trình của chúng tôi đều khác biệt và đáng nhớ.'
            ]),
            'image' => 'images/ontheground.webp',
            'link_url' => 'http://kids-edu.local/',
        ]);
    }
}
