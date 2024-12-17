<?php

namespace Database\Seeders;

use App\Models\CategoryMarket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryMarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Chợ An Nhơn', 'slug' => 'cho-an-nhon', 'banner' => null],
            ['name' => 'Chợ Tự phát Căn cứ 26A', 'slug' => 'cho-tu-phat-can-cu-26a', 'banner' => null],
            ['name' => 'Hộ kinh doanh', 'slug' => 'ho-kinh-doanh', 'banner' => null],
        ];

        foreach ($categories as $category) {
            CategoryMarket::create($category);
        }
    }
}
