<?php

namespace Database\Seeders;

use App\Models\Tab;
use App\Models\TabDrop;
use App\Models\TabImgContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'Pedagogy',
            'vi' => 'Phương pháp giáo dục',
        ]);

        $tabs->slug = "phuong-phap-giao-duc";
        $tabs->key_page = "programs";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();

        $tabs->save();

 //-----------------------------------------------------------------------------------
        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'Phương pháp giảng dạy cá nhân hóa',
            'vi' => 'Phương pháp giảng dạy cá nhân hóa',
        ]);

        $tabs_img_content->setTranslations('content', [
            'en' => 'Brighton Academy Singapore tin rằng mỗi học sinh là một thiên tài, mỗi cá thể sẽ có sự phát triển của não bộ khác nhau nên sẽ có những đặc điểm, tính cách, sở trường, sở thích khác nhau. Để phù hợp với từng nhóm tuổi và của mỗi cá nhân sẽ có một hành trình học tập riêng biệt, từ đó điều chỉnh phương pháp giảng dạy phù hợp với sở thích học tập, thế mạnh và khả năng phát triển của mỗi em. Đội ngũ giáo viên sẽ lên kế hoạch giảng dạy với những trải nghiệm học tập hào hứng và sinh động, được thiết kế riêng phù hợp với khả năng của học sinh, đảm bảo các em đạt được các mục tiêu quan trọng trong học tập. Các bậc phụ huynh cũng sẽ được cập nhật thường xuyên về những bước tiếp theo trong hành trình học tập của học sinh. ',
            'vi' => 'Brighton Academy Singapore tin rằng mỗi học sinh là một thiên tài, mỗi cá thể sẽ có sự phát triển của não bộ khác nhau nên sẽ có những đặc điểm, tính cách, sở trường, sở thích khác nhau. Để phù hợp với từng nhóm tuổi và của mỗi cá nhân sẽ có một hành trình học tập riêng biệt, từ đó điều chỉnh phương pháp giảng dạy phù hợp với sở thích học tập, thế mạnh và khả năng phát triển của mỗi em. Đội ngũ giáo viên sẽ lên kế hoạch giảng dạy với những trải nghiệm học tập hào hứng và sinh động, được thiết kế riêng phù hợp với khả năng của học sinh, đảm bảo các em đạt được các mục tiêu quan trọng trong học tập. Các bậc phụ huynh cũng sẽ được cập nhật thường xuyên về những bước tiếp theo trong hành trình học tập của học sinh. '
        ]);

        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();

        //  ////////////////////////////////////////////
        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'Phương pháp học tập',
            'vi' => 'Phương pháp học tập',
        ]);

        $tabs_img_content->setTranslations('content', [
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
        ]);

        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();


 //-----------------------------------------------------------------------------------

        $tabs_drop = new TabDrop();

        $tabs_drop->setTranslations('title', [
            'en' => 'Phương pháp play-based learning (học tập thông qua vui chơi)',
            'vi' => 'Phương pháp play-based learning (học tập thông qua vui chơi)'
        ]);

        $tabs_drop->setTranslations('content', [
            'en' => ' “Trẻ em học tốt nhất thông qua vui chơi”.
                            Vui chơi kích thích trí tò mò và dạy bé những kỹ năng cần thiết. Thông qua việc chơi và mắc lỗi, bé học cách khám phá, chấp nhận rủi ro và sử dụng trí tưởng tượng của mình.
                            • Bé được quyết định xem mình muốn chơi gì và chơi như thế nào và tự mình khám phá trong bao lâu. Giáo viên có thể giám sát hoặc gợi ý, nhưng bé cần sử dụng trí tò mò của mình để quyết định xem nên làm gì.
                            • Học sinh được tự học và khám phá theo thời gian, tốc độ của riêng mình, không có những quy tắc cứng nhắc. Việc học tập của bé là dựa trên quá trình, không có mục tiêu cuối cùng là phải đạt được cái gì.
                            • Bé có thời gian trải nghiệm thú vị, vui vẻ. Con được kết nối với những gì mình đang làm mà không bị ép buộc.
                            • Học sinh có quyền tự do tưởng tượng, sáng tạo không giới hạn. Giáo viên hỗ trợ, động viên và hướng dẫn bé ở môi trường học tập trong nhà và ngoài trời.
                            • Học tập qua vui chơi giúp bé phát triển toàn diện cả cảm xúc, thể chất, nhận thức, kỹ năng ngôn ngữ, giao tiếp, lắng nghe… Phương pháp này cũng phát huy trí tưởng tượng và sự sáng tạo của bé, đồng thời hỗ trợ phát triển các kỹ năng vận động tinh.
                            ',
            'vi' => ' “Trẻ em học tốt nhất thông qua vui chơi”.
                            Vui chơi kích thích trí tò mò và dạy bé những kỹ năng cần thiết. Thông qua việc chơi và mắc lỗi, bé học cách khám phá, chấp nhận rủi ro và sử dụng trí tưởng tượng của mình.
                            • Bé được quyết định xem mình muốn chơi gì và chơi như thế nào và tự mình khám phá trong bao lâu. Giáo viên có thể giám sát hoặc gợi ý, nhưng bé cần sử dụng trí tò mò của mình để quyết định xem nên làm gì.
                            • Học sinh được tự học và khám phá theo thời gian, tốc độ của riêng mình, không có những quy tắc cứng nhắc. Việc học tập của bé là dựa trên quá trình, không có mục tiêu cuối cùng là phải đạt được cái gì.
                            • Bé có thời gian trải nghiệm thú vị, vui vẻ. Con được kết nối với những gì mình đang làm mà không bị ép buộc.
                            • Học sinh có quyền tự do tưởng tượng, sáng tạo không giới hạn. Giáo viên hỗ trợ, động viên và hướng dẫn bé ở môi trường học tập trong nhà và ngoài trời.
                            • Học tập qua vui chơi giúp bé phát triển toàn diện cả cảm xúc, thể chất, nhận thức, kỹ năng ngôn ngữ, giao tiếp, lắng nghe… Phương pháp này cũng phát huy trí tưởng tượng và sự sáng tạo của bé, đồng thời hỗ trợ phát triển các kỹ năng vận động tinh.'
        ]);

        $tabs_drop->tab_id = $tabs->id;
        $tabs_drop->image = 'images/program2.png';
        $tabs_drop->icon = '';
        $tabs_drop->bg_color = '#43BFC6';
        $tabs_drop->created_at = now();
        $tabs_drop->updated_at = now();
        $tabs_drop->save();

 //-----------------------------------------------------------------------------------


        $tabs_drop = new TabDrop();

        $tabs_drop->setTranslations('title', [
            'en' => 'Phương pháp tiếp cận dự án',
            'vi' => 'Phương pháp tiếp cận dự án'
        ]);

        $tabs_drop->setTranslations('content', [
            'en' => 'Phương pháp này nhấn mạnh việc nuôi dưỡng trẻ toàn diện bằng cách phát triển năm giác quan với các trải nghiệm học tập mang tính thực hành kỹ năng và nghệ thuật
                            Giáo viên tạo điều kiện cho trẻ hứng thú tìm hiểu, dẫn dắt trẻ suy nghĩ phản biện và sáng tạo. Tùy thuộc từng chủ đề của dự án. Trẻ em tham gia vào các dự án để giải quyết các vấn đề thực tế và khám phá các chủ đề mới.

                            Đặc điểm của phương pháp Tiếp cận dự án:
                              • Học sinh là người học tích cực và thu nhận kiến thức về thế giới xung quang thông qua các trải nghiệm thực tế.
                              • Phương pháp này chú trọng đến tính sáng tạo và trí tưởng tượng hơn là học thuật.
                              • Phương pháp Tiếp cận dự án có một vài điểm tương đồng với học thông qua trò chơi. Tức là chủ trương dạy bé các bài học thông qua các hoạt động thực hành như xếp hình, chơi đất sét, làm bánh, làm vườn…
                              • Trẻ mẫu giáo thường làm việc trong môi trường nhóm không cạnh tranh. Bé có quyền quyết định xem nên học bằng cách sử dụng phương pháp thực hành hay thông qua quan sát.
                            ',
            'vi' => 'Phương pháp này nhấn mạnh việc nuôi dưỡng trẻ toàn diện bằng cách phát triển năm giác quan với các trải nghiệm học tập mang tính thực hành kỹ năng và nghệ thuật
                            Giáo viên tạo điều kiện cho trẻ hứng thú tìm hiểu, dẫn dắt trẻ suy nghĩ phản biện và sáng tạo. Tùy thuộc từng chủ đề của dự án. Trẻ em tham gia vào các dự án để giải quyết các vấn đề thực tế và khám phá các chủ đề mới.

                             Đặc điểm của phương pháp Tiếp cận dự án:
                              • Học sinh là người học tích cực và thu nhận kiến thức về thế giới xung quang thông qua các trải nghiệm thực tế.
                              • Phương pháp này chú trọng đến tính sáng tạo và trí tưởng tượng hơn là học thuật.
                              • Phương pháp Tiếp cận dự án có một vài điểm tương đồng với học thông qua trò chơi. Tức là chủ trương dạy bé các bài học thông qua các hoạt động thực hành như xếp hình, chơi đất sét, làm bánh, làm vườn…
                              • Trẻ mẫu giáo thường làm việc trong môi trường nhóm không cạnh tranh. Bé có quyền quyết định xem nên học bằng cách sử dụng phương pháp thực hành hay thông qua quan sát.
                            '
        ]);

        $tabs_drop->tab_id = $tabs->id;
        $tabs_drop->image = 'images/program2.png';
        $tabs_drop->icon = '';
        $tabs_drop->bg_color = '#71C541';
        $tabs_drop->created_at = now();
        $tabs_drop->updated_at = now();
        $tabs_drop->save();


 //-----------------------------------------------------------------------------------

        $tabs_drop = new TabDrop();

        $tabs_drop->setTranslations('title', [
            'en' => 'Phương pháp giáo dục STEM',
            'vi' => 'Phương pháp giáo dục STEM'
        ]);

        $tabs_drop->setTranslations('content', [
            'en' => 'STEM là từ viết tắt của khoa học, công nghệ, kỹ thuật và toán học. Đây là một thuật ngữ thường được sử dụng để chỉ giáo dục khoa học. Phương pháp này bắt nguồn từ quan điểm của các nghiên cứu cho rằng trẻ em được tiếp xúc với khoa học ngay từ khi còn nhỏ có rất nhiều lợi ích.
            Mục tiêu của phương pháp này là thu hút trẻ nhỏ tham gia khám phá khoa học bằng cách tiếp cận với các hoạt động trải nghiệm thực tế, chẳng hạn như chơi xếp hình.

            Đặc điểm của phương pháp STEM:
              • Trẻ em được cung cấp tài liệu và mời tham gia “thử nghiệm”. Giáo viên đóng vai trò là người dẫn dắt đồng thời đưa ra các yêu cầu để bé thử thách khả năng của mình.
              • Học sinh được thảo luận, chia sẻ các câu hỏi, quan sát và rút ra bài học cho mình.
              • Các chương trình STEM cũng tích hợp hoạt động khám phá khoa học vào các hoạt động hàng ngày như làm vườn và vui chơi ngoài trời.
              • Phương pháp này không đặt nặng lý thuyết, lấy thực hành và các trải nghiệm thực tế làm bài học cho bé.
              • Trẻ học được cách phân tích, giải quyết vấn đề một cách chủ động, qua đó phát huy khả năng sáng tạo.
            ',
            'vi' => 'STEM là từ viết tắt của khoa học, công nghệ, kỹ thuật và toán học. Đây là một thuật ngữ thường được sử dụng để chỉ giáo dục khoa học. Phương pháp này bắt nguồn từ quan điểm của các nghiên cứu cho rằng trẻ em được tiếp xúc với khoa học ngay từ khi còn nhỏ có rất nhiều lợi ích.
            Mục tiêu của phương pháp này là thu hút trẻ nhỏ tham gia khám phá khoa học bằng cách tiếp cận với các hoạt động trải nghiệm thực tế, chẳng hạn như chơi xếp hình.

             Đặc điểm của phương pháp STEM:
              • Trẻ em được cung cấp tài liệu và mời tham gia “thử nghiệm”. Giáo viên đóng vai trò là người dẫn dắt đồng thời đưa ra các yêu cầu để bé thử thách khả năng của mình.
              • Học sinh được thảo luận, chia sẻ các câu hỏi, quan sát và rút ra bài học cho mình.
              • Các chương trình STEM cũng tích hợp hoạt động khám phá khoa học vào các hoạt động hàng ngày như làm vườn và vui chơi ngoài trời.
              • Phương pháp này không đặt nặng lý thuyết, lấy thực hành và các trải nghiệm thực tế làm bài học cho bé.
              • Trẻ học được cách phân tích, giải quyết vấn đề một cách chủ động, qua đó phát huy khả năng sáng tạo.
            '
        ]);

        $tabs_drop->tab_id = $tabs->id;
        $tabs_drop->image = 'images/program2.png';
        $tabs_drop->icon = '';
        $tabs_drop->bg_color = '#9C2530';
        $tabs_drop->created_at = now();
        $tabs_drop->updated_at = now();
        $tabs_drop->save();


 //-----------------------------------------------------------------------------------

        $tabs_drop = new TabDrop();

        $tabs_drop->setTranslations('title', [
            'en' => 'Phương pháp giáo dục mầm non Montessori',
            'vi' => 'Phương pháp giáo dục mầm non Montessori'
        ]);

        $tabs_drop->setTranslations('content', [
            'en' => 'Phương pháp Montessori bắt nguồn từ cách tiếp cận giáo dục theo chủ nghĩa cá nhân và dựa theo nguyên tắc mọi trẻ em đều có bản chất tò mò và khả năng học tập độc lập.

                            Đặc điểm của phương pháp Montessori:
                              • Hướng đến trẻ, lấy học sinh làm trung tâm; giáo viên đóng vai trò là người hướng dẫn, đánh giá đồng thời thiết kế các hoạt động phù hợp cho con.
                              • Bé có thể học tập và phát triển theo tốc độ riêng của mình. Môi trường Montessori tạo cơ hội cho con phát triển các kỹ năng cá nhân và tính độc lập (khác với Reggio Emilia).
                              • Bé có cơ hội tự khám phá, trải nghiệm và tự chịu trách nhiệm cho việc làm của mình.
                              • Lớp học được chuẩn bị kỹ lưỡng với các góc hoặc tài liệu theo chuẩn Montessori.
                              •  Lớp có thể gồm học sinh ở nhiều lứa tuổi khác nhau.
                            ',
            'vi' => 'Phương pháp Montessori bắt nguồn từ cách tiếp cận giáo dục theo chủ nghĩa cá nhân và dựa theo nguyên tắc mọi trẻ em đều có bản chất tò mò và khả năng học tập độc lập.

                             Đặc điểm của phương pháp Montessori:
                              • Hướng đến trẻ, lấy học sinh làm trung tâm; giáo viên đóng vai trò là người hướng dẫn, đánh giá đồng thời thiết kế các hoạt động phù hợp cho con.
                              • Bé có thể học tập và phát triển theo tốc độ riêng của mình. Môi trường Montessori tạo cơ hội cho con phát triển các kỹ năng cá nhân và tính độc lập (khác với Reggio Emilia).
                              • Bé có cơ hội tự khám phá, trải nghiệm và tự chịu trách nhiệm cho việc làm của mình.
                              • Lớp học được chuẩn bị kỹ lưỡng với các góc hoặc tài liệu theo chuẩn Montessori.
                              •  Lớp có thể gồm học sinh ở nhiều lứa tuổi khác nhau.
                            '
        ]);

        $tabs_drop->tab_id = $tabs->id;
        $tabs_drop->image = 'images/program2.png';
        $tabs_drop->icon = '';
        $tabs_drop->bg_color = '#FFA655';
        $tabs_drop->created_at = now();
        $tabs_drop->updated_at = now();
        $tabs_drop->save();

 //-----------------------------------------------------------------------------------

        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'Mini project Development',
            'vi' => 'Phát triển các dự án mini',
        ]);

        $tabs->slug = "phat-trien-cac-du-an-mini";
        $tabs->key_page = "programs";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();

        $tabs->save();
    }
}
