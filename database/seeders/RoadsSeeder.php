<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roads = [
            ['name' => 'Lê Đức Thọ', 'slug' => 'le-duc-tho'],
            ['name' => 'Lê Thị Hồng', 'slug' => 'le-thi-hong'],
            ['name' => 'Nguyễn Oanh', 'slug' => 'nguyen-oanh'],
            ['name' => 'An Nhơn', 'slug' => 'an-nhon'],
            ['name' => 'Phạm Huy Thông', 'slug' => 'pham-huy-thong'],
            ['name' => 'Nguyễn Văn Lượng', 'slug' => 'nguyen-van-luong'],
            ['name' => 'Chợ An Nhơn', 'slug' => 'cho-an-nhon'],
            ['name' => 'Lê Hoàng Phái', 'slug' => 'le-hoang-phai'],
            ['name' => 'Đường số 5', 'slug' => 'duong-so-5'],
            ['name' => 'Đường số 8', 'slug' => 'duong-so-8'],
            ['name' => 'Đường số 11', 'slug' => 'duong-so-11'],
            ['name' => 'Đường số 12', 'slug' => 'duong-so-12'],
            ['name' => 'Đường số 15', 'slug' => 'duong-so-15'],
            ['name' => 'Đường số 9', 'slug' => 'duong-so-9'],
            ['name' => 'Đường số 14', 'slug' => 'duong-so-14'],
            ['name' => 'Đường số 4', 'slug' => 'duong-so-4'],
            ['name' => 'Đường số 7', 'slug' => 'duong-so-7'],
            ['name' => 'Đường số 1', 'slug' => 'duong-so-1'],
            ['name' => 'Đường số 17', 'slug' => 'duong-so-17'],
            ['name' => 'Phan Văn Trị', 'slug' => 'phan-van-tri'],
            ['name' => 'Đường số 16', 'slug' => 'duong-so-16'],
            ['name' => 'Đường số 20', 'slug' => 'duong-so-20'],
            ['name' => 'Đường số 2', 'slug' => 'duong-so-2'],
            ['name' => 'Đường số 13', 'slug' => 'duong-so-13'],
            ['name' => 'Trương Minh Giảng', 'slug' => 'truong-minh-giang'],
            ['name' => 'Đường số 3', 'slug' => 'duong-so-3'],
            ['name' => 'Đường 26/3', 'slug' => 'duong-26/3'],
            ['name' => 'Đường số 6', 'slug' => 'duong-so-6'],
            ['name' => 'Nguyễn Huy Điển', 'slug' => 'nguyen-huy-dien'],
            ['name' => 'Căn cứ 26', 'slug' => 'can-cu-26'],
            ['name' => 'Đường số 24', 'slug' => 'duong-so-24'],
            ['name' => 'Điện Biên Phủ', 'slug' => 'dien-bien-phu'],
            ['name' => 'Dương Quảng Hàm', 'slug' => 'duong-quang-ham'],
            ['name' => 'Đường số 25', 'slug' => 'duong-so-25'],
            ['name' => 'Đường số 30', 'slug' => 'duong-so-30'],
            ['name' => 'Đường số 27', 'slug' => 'duong-so-27'],
            ['name' => 'Đường số 29', 'slug' => 'duong-so-29'],
            ['name' => 'Đường 20', 'slug' => 'duong-20'],
            ['name' => 'Đường số 21', 'slug' => 'duong-so-21'],
            ['name' => 'Đường số 10', 'slug' => 'duong-so-10'],
            ['name' => 'Nguyễn Văn Dung', 'slug' => 'nguyen-van-dung'],
            ['name' => 'Cư xá Lam Sơn', 'slug' => 'cu-xa-lam-son'],
            ['name' => 'Lê Văn Thọ', 'slug' => 'le-van-tho'],
            ['name' => 'Đường số 19', 'slug' => 'duong-so-19'],
        ];

        foreach ($roads as $road) {
            DB::table('roads')->updateOrInsert(
                ['slug' => $road['slug']],
                ['name' => $road['name'], 'slug' => $road['slug']]
            );
        }
    }
}
