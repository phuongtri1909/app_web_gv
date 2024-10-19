<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TabImgContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tabs_img_contents')->insert([
            [
                'tab_id' => 1,
                'title' => json_encode(['en' => 'Phương pháp giảng dạy cá nhân hóa', 'vi' => 'Phương pháp giảng dạy cá nhân hóa']),
                'content' => json_encode(
                    [
                        'en' => 'Brighton Academy Singapore tin rằng mỗi học sinh là một thiên tài, mỗi cá thể sẽ có sự phát triển của não bộ khác nhau nên sẽ có những đặc điểm, tính cách, sở trường, sở thích khác nhau. Để phù hợp với từng nhóm tuổi và của mỗi cá nhân sẽ có một hành trình học tập riêng biệt, từ đó điều chỉnh phương pháp giảng dạy phù hợp với sở thích học tập, thế mạnh và khả năng phát triển của mỗi em. Đội ngũ giáo viên sẽ lên kế hoạch giảng dạy với những trải nghiệm học tập hào hứng và sinh động, được thiết kế riêng phù hợp với khả năng của học sinh, đảm bảo các em đạt được các mục tiêu quan trọng trong học tập. Các bậc phụ huynh cũng sẽ được cập nhật thường xuyên về những bước tiếp theo trong hành trình học tập của học sinh. ',
                        'vi' => 'Brighton Academy Singapore tin rằng mỗi học sinh là một thiên tài, mỗi cá thể sẽ có sự phát triển của não bộ khác nhau nên sẽ có những đặc điểm, tính cách, sở trường, sở thích khác nhau. Để phù hợp với từng nhóm tuổi và của mỗi cá nhân sẽ có một hành trình học tập riêng biệt, từ đó điều chỉnh phương pháp giảng dạy phù hợp với sở thích học tập, thế mạnh và khả năng phát triển của mỗi em. Đội ngũ giáo viên sẽ lên kế hoạch giảng dạy với những trải nghiệm học tập hào hứng và sinh động, được thiết kế riêng phù hợp với khả năng của học sinh, đảm bảo các em đạt được các mục tiêu quan trọng trong học tập. Các bậc phụ huynh cũng sẽ được cập nhật thường xuyên về những bước tiếp theo trong hành trình học tập của học sinh. '
                    ]
                ),
                'image' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tab_id' => 1,
                'title' => json_encode(['en' => 'Phương pháp học tập', 'vi' => 'Phương pháp học tập']),
                'content' => json_encode([
                    'en' => 'Toàn bộ chương trình được thiết kế chuyên biệt, phù hợp với đặc điểm tâm lý của từng độ tuổi, từng cá thể của trẻ theo Nurturing Early Learners Framework - Singapore, chương trình tập trung vào các hoạt động trải nghiệm theo hướng lấy trẻ làm trung tâm trong mọi hoạt động. Brighton Academy Singapore sẽ tích hợp các phương pháp khác nhau tùy thuộc vào lĩnh vực môn học, thực hành kỹ năng và giúp trẻ tự chủ trong sáng tạo và chủ động trong học tập bao gồm:

                    • Môi trường học tập đa dạng chương trình học.
                    • Hoạt động (lặp lại) hàng ngày.
                    • Phát triển các kỹ năng, tính sáng tạo thông qua làm việc nhóm và phát triển dự án.
                    • Tích hợp các nội dung học.
                    • Tương tác giữa người lớn và trẻ em.',

                    'vi' => 'Toàn bộ chương trình được thiết kế chuyên biệt, phù hợp với đặc điểm tâm lý của từng độ tuổi, từng cá thể của trẻ theo Nurturing Early Learners Framework - Singapore, chương trình tập trung vào các hoạt động trải nghiệm theo hướng lấy trẻ làm trung tâm trong mọi hoạt động. Brighton Academy Singapore sẽ tích hợp các phương pháp khác nhau tùy thuộc vào lĩnh vực môn học, thực hành kỹ năng và giúp trẻ tự chủ trong sáng tạo và chủ động trong học tập bao gồm:

                    • Môi trường học tập đa dạng chương trình học.
                    • Hoạt động (lặp lại) hàng ngày.
                    • Phát triển các kỹ năng, tính sáng tạo thông qua làm việc nhóm và phát triển dự án.
                    • Tích hợp các nội dung học.
                    • Tương tác giữa người lớn và trẻ em. '
                ]),
                'image' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
