<?php

namespace Database\Seeders;

use App\Models\Tab;
use App\Models\TabImgContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TabTuyenSinhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'Admissions process',
            'vi' => 'Quy trình tuyển sinh',
        ]);

        $tabs->slug = "admissions-process";
        $tabs->key_page = "admissions";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();

        $tabs->save();

        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'Chào mừng quý vị đến với Học Viện Brighton - Singapore.',
            'vi' => 'Chào mừng quý vị đến với Học Viện Brighton - Singapore.',
        ]);

        $tabs_img_content->setTranslations('content', [
            'en' => 'Chúng tôi rất vinh dự khi được quý phụ huynh cân nhắc lựa chọn Học Viện Brighton - Singapore tại TP HCM cho con.

Sau khi quý phụ huynh hoàn thành biểu mẫu ngắn này, nhà trường sẽ phản hồi lại quý vị trong vòng 24 giờ (không bao gồm ngày cuối tuần và các kỳ nghỉ lễ) để hướng dẫn các bước tiếp theo. Học Viện Brighton - Singapore chào đón quý phụ huynh tới thăm trường qua hình thức trực tiếp hay trực tuyến nhằm giúp quý gia đình có cơ hội trải nghiệm môi trường giáo dục tại trường, đồng thời được giải đáp các thắc mắc nếu có.

Tham quan trường mang đến cảm nhận chân thực nhất về Học Viện Brighton - Singapore. Vui lòng thông tin thời gian thuận tiện quý phụ huynh có thể ghé thăm để giúp nhà trường sắp xếp đón tiếp gia đình chu đáo nhất.

Trường hợp quý phụ huynh gặp khó khăn về mặt kỹ thuật, vui lòng liên hệ đội ngũ Tuyển sinh của trường qua số điện thoại 0932 887 557
',
            'vi' => 'Chúng tôi rất vinh dự khi được quý phụ huynh cân nhắc lựa chọn Học Viện Brighton - Singapore tại TP HCM cho con.

Sau khi quý phụ huynh hoàn thành biểu mẫu ngắn này, nhà trường sẽ phản hồi lại quý vị trong vòng 24 giờ (không bao gồm ngày cuối tuần và các kỳ nghỉ lễ) để hướng dẫn các bước tiếp theo. Học Viện Brighton - Singapore chào đón quý phụ huynh tới thăm trường qua hình thức trực tiếp hay trực tuyến nhằm giúp quý gia đình có cơ hội trải nghiệm môi trường giáo dục tại trường, đồng thời được giải đáp các thắc mắc nếu có.

Tham quan trường mang đến cảm nhận chân thực nhất về Học Viện Brighton - Singapore. Vui lòng thông tin thời gian thuận tiện quý phụ huynh có thể ghé thăm để giúp nhà trường sắp xếp đón tiếp gia đình chu đáo nhất.

Trường hợp quý phụ huynh gặp khó khăn về mặt kỹ thuật, vui lòng liên hệ đội ngũ Tuyển sinh của trường qua số điện thoại 0932 887 557
',
        ]);

        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();

        //-----------------------------------------------------------------------------------

        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'Tuition fees',
            'vi' => 'Biểu học phí',
        ]);

        $tabs->slug = "tuition-fees";
        $tabs->key_page = "admissions";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();
        $tabs->save();

        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'Biểu học phí',
            'vi' => 'Biểu học phí',
        ]);

        $tabs_img_content->setTranslations('content', [
            'en' => 'Biểu học phí của BrightonSingapore',
            'vi' => 'Biểu học phí của BrightonSingapore',
        ]);

        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();

        //-----------------------------------------------------------------------------------

        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'Refund tuition fees',
            'vi' => 'Hoàn trả học phí',
        ]);

        $tabs->slug = "refund-tuition-fees";
        $tabs->key_page = "admissions";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();
        $tabs->save();

        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'Hoàn trả học phí',
            'vi' => 'Hoàn trả học phí',
        ]);

        $tabs_img_content->setTranslations('content', [
            'en' => 'Hoàn trả học phí của BrightonSingapore',
            'vi' => 'Hoàn trả học phí của BrightonSingapore',
        ]);

        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();

        //-----------------------------------------------------------------------------------

        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'School calendar',
            'vi' => 'Lịch học trong năm',
        ]);

        $tabs->slug = "school-calendar";
        $tabs->key_page = "admissions";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();
        $tabs->save();

        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'Lịch học trong năm',
            'vi' => 'Lịch học trong năm',
        ]);

        $tabs_img_content->setTranslations('content', [
            'en' => 'Lịch học trong năm của BrightonSingapore',
            'vi' => 'Lịch học trong năm của BrightonSingapore',
        ]);

        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();

    }
}
