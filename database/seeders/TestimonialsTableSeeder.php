<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Thành Vũ-Pim',
                'avatar' => '/images/avt.jpg',
                'short_description' => 'Qua sự tư vấn tận tình, giải đáp mọi thắc mắc, ba mẹ quyết định chọn nơi đây để gửi gắm “cục vàng” của mình. Và cho đến bây giờ, khi con sắp rời trường thì ba mẹ biết quyết định ấy đã đúng.',
            ],
            [
                'name' => 'Tuấn-Pim',
                'avatar' => '/images/avt.jpg',
                'short_description' => 'Qua sự tư vấn tận tình, giải đáp mọi thắc mắc, ba mẹ quyết định chọn nơi đây để gửi gắm “cục vàng” của mình. Và cho đến bây giờ, khi con sắp rời trường thì ba mẹ biết quyết định ấy đã đúng.',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            DB::table('testimonials')->insert([
                'name' => $testimonial['name'],
                'avatar' => $testimonial['avatar'],
                'short_description' => $testimonial['short_description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
