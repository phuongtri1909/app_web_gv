<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactConsultationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consultations = [
            [
                'image' => 'images/contac-consultation/congthongtindoanhnghiep.png',
                'name' => 'Tra cứu thông tin doanh nghiệp',
                'link' => 'https://doanhnghiep.hochiminhcity.gov.vn',
            ],
            [
                'image' => 'images/contac-consultation/logo-gv.jpg',
                'name' => 'Trang thông tin điện tử quận Gò Vấp',
                'link' => 'https://govap.hochiminhcity.gov.vn',
            ],
            [
                'image' => 'images/contac-consultation/logo-ITPC.png',
                'name' => 'Trung tâm xúc tiến thương mại thành phố Hồ Chí Minh',
                'link' => 'http://www.itpc.gov.vn/web/vi/home',
            ],
            [
                'image' => 'images/contac-consultation/logo_so_vn_border.png',
                'name' => 'Sở khoa học công nghệ Hồ Chí Minh',
                'link' => 'https://dost.hochiminhcity.gov.vn/',
            ],
            [
                'image' => 'images/contac-consultation/congthongtindoanhnghiep.png',
                'name' => 'Doanh nghiệp hỏi đáp trực tuyến',
                'link' => 'https://doanhnghiep.hochiminhcity.gov.vn/HoiDap/',
            ],
            [
                'image' => 'images/contac-consultation/logo-gv.jpg',
                'name' => 'Gò Vấp Smart',
                'link' => 'https://zalo.me/s/1754494419639257765/',
            ],
            [
                'image' => 'images/contac-consultation/logo-dich-vu-cong.png',
                'name' => 'Đăng Ký Thuế Hồ Chí Minh',
                'link' => 'https://dichvucong.gov.vn/p/home/dvc-tra-cuu-ho-so.html?typeInapp=1',
            ],
            [
                'image' => 'images/contac-consultation/logo-hanhchinh.png',
                'name' => 'Đăng ký thành lập doanh nghiệp trực tuyến',
                'link' => 'https://dichvucong.hochiminhcity.gov.vn/vi/procedure/detail/629dae4edb4662230f940e11?keyword=Th%C3%A0nh%20l%E1%BA%ADp%20doanh%20nghi%E1%BB%87p&page=1&size=10&procedure=&sector=&agency=&tab=&province=&commune=&department=',
            ],
            [
                'image' => 'images/logo.png',
                'name' => 'Liên hệ tổ tư vấn',
                'link' => 'https://zalo.me/1952194021145272783',
            ]
          
        ];

        DB::table('contact_consultations')->insert($consultations);
    }
}
