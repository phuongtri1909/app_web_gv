<?php

namespace Database\Seeders;

use App\Models\CategoryProgram;
use App\Models\ProgramOverview;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new CategoryProgram();
        $category->key_page = 'page_home';
            $category->setTranslations('name_category', [
                'en' => 'CHƯƠNG TRÌNH MẦM NON QUỐC TẾ – BRIGHTON ACADEMY - SINGAPORE',
                'vi' => 'CHƯƠNG TRÌNH MẦM NON QUỐC TẾ – BRIGHTON ACADEMY - SINGAPORE'
            ]);
           
               
            $category->setTranslations('desc_category', [
                'en' => 'Chương trình học sẽ áp dụng những phương pháp đúng theo quy tắc sự phát triển não bộ của trẻ trong giai đoạn vàng (theo nghiên cứu của đại học Harvard Hoa Kỳ), chương trình chú trọng các hoạt động trải nghiệm theo hướng lấy trẻ làm trung tâm trong mọi hoạt động. Toàn bộ chương trình được thiết kế riêng, phù hợp với đặc điểm tâm sinh lý của mỗi độ tuổi, mỗi cá nhân của trẻ, xuyên suốt quá trình học tập và nuôi dạy trẻ từ 18 tháng đến 6 tuổi xoay quanh các 5 lĩnh vực chính phát triển toàn diện bao gồm:
•	Phát triển về Ngôn ngữ
•	Phát triển về Nhận thức và Văn hóa 
•	Phát triển về Thể chất
•	Thực hành Kỹ năng sống
•	Phát triển về Toán

Chương trình sẽ mang lại những ấn tượng đầu đời sâu sắc và đẹp đẽ nhất cho con – Những chủ nhân tương lai của đất nước.',
                'vi' => 'Chương trình học sẽ áp dụng những phương pháp đúng theo quy tắc sự phát triển não bộ của trẻ trong giai đoạn vàng (theo nghiên cứu của đại học Harvard Hoa Kỳ), chương trình chú trọng các hoạt động trải nghiệm theo hướng lấy trẻ làm trung tâm trong mọi hoạt động. Toàn bộ chương trình được thiết kế riêng, phù hợp với đặc điểm tâm sinh lý của mỗi độ tuổi, mỗi cá nhân của trẻ, xuyên suốt quá trình học tập và nuôi dạy trẻ từ 18 tháng đến 6 tuổi xoay quanh các 5 lĩnh vực chính phát triển toàn diện bao gồm:
•	Phát triển về Ngôn ngữ
•	Phát triển về Nhận thức và Văn hóa 
•	Phát triển về Thể chất
•	Thực hành Kỹ năng sống
•	Phát triển về Toán

Chương trình sẽ mang lại những ấn tượng đầu đời sâu sắc và đẹp đẽ nhất cho con – Những chủ nhân tương lai của đất nước.'
            ]);

        $category->save();

        $category = new CategoryProgram();

        $category->key_page = 'key_cb2';
            $category->setTranslations('name_category', [
                'en' => 'Category for component 2',
                'vi' => 'Danh mục cho chương trình component 2'
            ]);
           
               
            $category->setTranslations('desc_category', [
                'en' => '',
                'vi' => ''
            ]);

        $category->save();

        $category = new CategoryProgram();
        $category->key_page = 'page_program';
            $category->setTranslations('name_category', [
                'en' => 'Title overview program',
                'vi' => 'Title mục tổng quan chương trình'
            ]);
               
            $category->setTranslations('desc_category', [
                'en' => '',
                'vi' => ''
            ]);
    }
}
