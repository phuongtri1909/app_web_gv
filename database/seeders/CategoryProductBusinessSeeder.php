<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryProductBusiness;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryProductBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Dịch vụ thương mại', 'slug' => 'dich-vu-thuong-mai'],
            ['name' => 'Đồ gia dụng', 'slug' => 'do-gia-dung'],
            ['name' => 'Thực phẩm đóng gói', 'slug' => 'thuc-pham-dong-goi'],
            ['name' => 'Sản phẩm tiêu dùng', 'slug' => 'san-pham-tieu-dung'],
            ['name' => 'Thực phẩm chế biến', 'slug' => 'thuc-pham-che-bien'],
            ['name' => 'Khác', 'slug' => 'khac'],
            ['name' => 'Hợp tác kinh doanh', 'slug' => 'hop-tac-kinh-doanh'],
            ['name' => 'Thủy hải sản', 'slug' => 'thuy-hai-san'],
            ['name' => 'Đồ uống các loại', 'slug' => 'do-uong-cac-loai'],
            ['name' => 'Rau gia vị', 'slug' => 'rau-gia-vi'],
            ['name' => 'Rau củ đóng gói', 'slug' => 'rau-cu-dong-goi'],
            ['name' => 'Rau củ quả', 'slug' => 'rau-cu-qua'],
            ['name' => 'Trái cây', 'slug' => 'trai-cay'],
            ['name' => 'Rau củ sấy khô', 'slug' => 'rau-cu-say-kho'],
            ['name' => 'Gia súc gia cầm', 'slug' => 'gia-suc-gia-cam'],
            ['name' => 'Rau ăn củ', 'slug' => 'rau-an-cu'],
            ['name' => 'Rau ăn lá', 'slug' => 'rau-an-la'],
            ['name' => 'Rau ăn quả', 'slug' => 'rau-an-qua'],
            ['name' => 'Dịch vụ du lịch', 'slug' => 'dich-vu-du-lich'],
        ];

        foreach ($categories as $category) {
            CategoryProductBusiness::create($category);
        }
    }
}
