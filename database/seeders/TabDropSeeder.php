<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TabDropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tabs_drop')->insert([
            [
                'tab_id' => 1,
                'title' => json_encode(['en' => 'Phương pháp play-based learning (học tập thông qua vui chơi)', 'vi' => 'Phương pháp play-based learning (học tập thông qua vui chơi)']),
                'image' => 'images/program2.png',
                'content' => json_encode([
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
                ]),
                'icon' => '',
                'bg_color' => '#43BFC6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tab_id' => 1,
                'title' => json_encode(['en' => 'Phương pháp tiếp cận dự án', 'vi' => 'Phương pháp tiếp cận dự án']),
                'image' => 'images/program2.png',
                'content' => json_encode([
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
                ]),
                'icon' => '',
                'bg_color' => '#71C541',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tab_id' => 1,
                'title' => json_encode(['en' => 'Phương pháp giáo dục STEM', 'vi' => 'Phương pháp giáo dục STEM']),
                'image' => 'images/program2.png',
                'content' => json_encode([
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
                ]),
                'icon' => '',
                'bg_color' => '#9C2530',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tab_id' => 1,
                'title' => json_encode(['en' => 'Phương pháp giáo dục mầm non Montessori', 'vi' => 'Phương pháp giáo dục mầm non Montessori']),
                'image' => 'images/program2.png',
                'content' => json_encode([
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
                ]),
                'icon' => '',
                'bg_color' => '#FFA655',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records as needed
        ]);
    }
}
