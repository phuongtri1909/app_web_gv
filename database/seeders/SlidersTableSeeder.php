<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sliders')->insert([
            [
                'slider_title' => json_encode([
                    'en' => 'Our growing list of destinations...',
                    'vi' => 'Danh mục điểm đến ngày càng tăng của chúng tôi...',
                ]),
                'title' => json_encode([
                    'en' => 'Thailand:',
                    'vi' => 'Thái Lan:',
                ]),
                'subtitle' => json_encode([
                    'en' => 'Asia’s iconic playground',
                    'vi' => 'Sân chơi mang tính biểu tượng của châu Á',
                ]),
                'description' => json_encode([
                    'en' => 'With its laid-back beaches, excellent cuisine, and friendly people, Thailand is truly deserving of its reputation as the perfect vacation spot. We provide reliable service partners and creative itineraries managed by those who know it best.',
                    'vi' => 'Với những bãi biển bình dị, ẩm thực tuyệt vời và con người thân thiện, Thái Lan xứng đáng được mệnh danh là điểm đến nghỉ dưỡng hoàn hảo. Kid cung cấp cho các đối tác dịch vụ đáng tin cậy và những hành trình sáng tạo được quản lý bởi những người hiểu rõ nhất về nó.',
                ]),
                'image_slider' => '/images/Thailand.jpg',
                'learn_more_url' => 'http://kids.edu.local/',
                'active' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
                'key_page' => 'key_home',

            ],
            [
                'slider_title' => json_encode([
                    'en' => 'Our growing list of destinations...',
                    'vi' => 'Danh mục điểm đến ngày càng tăng của chúng tôi...',
                ]),
                'title' => json_encode([
                    'en' => 'Indonesia:',
                    'vi' => 'Indonesia:',
                ]),
                'subtitle' => json_encode([
                    'en' => '17,000 reasons to smile',
                    'vi' => '17.000 lý do để mỉm cười',
                ]),
                'description' => json_encode([
                    'en' => 'From steaming volcanoes and coral-rich beaches to mysterious cultures and delicious cuisine, Indonesia is a land of endless possibilities. We are your reliable arm in navigating this diverse and wonderful archipelago.',
                    'vi' => 'Từ những ngọn núi lửa đang bốc hơi và những bãi biển có nhiều san hô đến những nền văn hóa huyền bí và ẩm thực ngon lành, Indonesia là một đất nước tràn đầy những khả năng. Kid Indonesia là cánh tay đáng tin cậy của bạn trong việc định hướng quần đảo đa dạng và tuyệt vời này.',
                ]),
                'image_slider' => '/images/Indonesia.jpg',
                'learn_more_url' => 'http://kids.edu.local/',
                'active' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
                'key_page' => 'key_home',
            ],
        ]);
    }
}
