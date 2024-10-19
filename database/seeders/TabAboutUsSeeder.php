<?php

namespace Database\Seeders;

use App\Models\Tab;
use App\Models\TabDrop;
use App\Models\TabImgContent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TabAboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'About Us',
            'vi' => 'Về chúng tôi',
        ]);
        $tabs->slug = "brighton-academy";
        $tabs->key_page = "about-us";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();
        $tabs->save();

        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'About Us',
            'vi' => 'Về chúng tôi',
        ]);
        $tabs_img_content->setTranslations('content', [
            'en' => 'Brighton Academy is a private school in Ho Chi Minh City, Vietnam. We offer a comprehensive education program from kindergarten to high school. Our school is committed to providing a safe and nurturing environment for students to learn and grow. We believe that every child has the potential to succeed and we are dedicated to helping them reach their full potential. Our teachers are passionate about education and are dedicated to helping students achieve their goals. We offer a challenging curriculum that is designed to prepare students for success in college and beyond. Our school is a place where students can learn, grow, and thrive. We invite you to learn more about our school and see how we can help your child succeed.',
            'vi' => 'Chúng tôi là một trường tư thục tại Thành phố Hồ Chí Minh, Việt Nam. Chúng tôi cung cấp một chương trình giáo dục toàn diện từ mẫu giáo đến trung học. Trường của chúng tôi cam kết cung cấp một môi trường an toàn và nuôi dưỡng cho học sinh học tập và phát triển. Chúng tôi tin rằng mỗi đứa trẻ đều có tiềm năng để thành công và chúng tôi cam kết giúp họ đạt được tiềm năng đầy đủ của mình. Giáo viên của chúng tôi đam mê với giáo dục và cam kết giúp học sinh đạt được mục tiêu của mình. Chúng tôi cung cấp một chương trình học tập thách thức được thiết kế để chuẩn bị học sinh cho sự thành công trong đại học và xa hơn nữa. Trường của chúng tôi là nơi mà học sinh có thể học tập, phát triển và phát triển. Chúng tôi mời bạn tìm hiểu thêm về trường của chúng tôi và xem làm thế nào chúng tôi có thể giúp đỡ con bạn thành công.',
        ]);
        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();

        //------------------------------------------------------------------------------------------------------------

        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'component 3',
            'vi' => 'component 3',
        ]);
        $tabs->slug = "component-3";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->key_page = "about-us-component-3";
        $tabs->created_at = now();
        $tabs->updated_at = now();
        $tabs->save();

        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'Vision',
            'vi' => 'Tầm nhìn',
        ]);

        $tabs_img_content->setTranslations('content', [
            'en' => 'Brighton Academy is a private school in Ho Chi Minh City, Vietnam. We offer a comprehensive education program from kindergarten to high school. Our school is committed to providing a safe and nurturing environment for students to learn and grow. We believe that every child has the potential to succeed and we are dedicated to helping them reach their full potential. Our teachers are passionate about education and are dedicated to helping students achieve their goals. We offer a challenging curriculum that is designed to prepare students for success in college and beyond. Our school is a place where students can learn, grow, and thrive. We invite you to learn more about our school and see how we can help your child succeed.',
            'vi' => 'Chúng tôi là một trường tư thục tại Thành phố Hồ Chí Minh, Việt Nam. Chúng tôi cung cấp một chương trình giáo dục toàn diện từ mẫu giáo đến trung học. Trường của chúng tôi cam kết cung cấp một môi trường an toàn và nuôi dưỡng cho học sinh học tập và phát triển. Chúng tôi tin rằng mỗi đứa trẻ đều có tiềm năng để thành công và chúng tôi cam kết giúp họ đạt được tiềm năng đầy đủ của mình. Giáo viên của chúng tôi đam mê với giáo dục và cam kết giúp học sinh đạt được mục tiêu của mình. Chúng tôi cung cấp một chương trình học tập thách thức được thiết kế để chuẩn bị học sinh cho sự thành công trong đại học và xa hơn nữa. Trường của chúng tôi là nơi mà học sinh có thể học tập, phát triển và phát triển. Chúng tôi mời bạn tìm hiểu thêm về trường của chúng tôi và xem làm thế nào chúng tôi có thể giúp đỡ con bạn thành công.',
        ]);

        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->image = "images/moitruonghoctap.jpg";
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();

        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'Mission',
            'vi' => 'Sứ mệnh',
        ]);

        $tabs_img_content->setTranslations('content', [
            'en' => 'Brighton Academy is a private school in Ho Chi Minh City, Vietnam. We offer a comprehensive education program from kindergarten to high school. Our school is committed to providing a safe and nurturing environment for students to learn and grow. We believe that every child has the potential to succeed and we are dedicated to helping them reach their full potential. Our teachers are passionate about education and are dedicated to helping students achieve their goals. We offer a challenging curriculum that is designed to prepare students for success in college and beyond. Our school is a place where students can learn, grow, and thrive. We invite you to learn more about our school and see how we can help your child succeed.',
            'vi' => 'Chúng tôi là một trường tư thục tại Thành phố Hồ Chí Minh, Việt Nam. Chúng tôi cung cấp một chương trình giáo dục toàn diện từ mẫu giáo đến trung học. Trường của chúng tôi cam kết cung cấp một môi trường an toàn và nuôi dưỡng cho học sinh học tập và phát triển. Chúng tôi tin rằng mỗi đứa trẻ đều có tiềm năng để thành công và chúng tôi cam kết giúp họ đạt được tiềm năng đầy đủ của mình. Giáo viên của chúng tôi đam mê với giáo dục và cam kết giúp học sinh đạt được mục tiêu của mình. Chúng tôi cung cấp một chương trình học tập thách thức được thiết kế để chuẩn bị học sinh cho sự thành công trong đại học và xa hơn nữa. Trường của chúng tôi là nơi mà học sinh có thể học tập, phát triển và phát triển. Chúng tôi mời bạn tìm hiểu thêm về trường của chúng tôi và xem làm thế nào chúng tôi có thể giúp đỡ con bạn thành công.',
        ]);

        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->image = "images/moitruonghoctap.jpg";
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();

        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'Core values',
            'vi' => 'Gía trị cốt lõi',
        ]);

        $tabs_img_content->setTranslations('content', [
            'en' => 'Brighton Academy is a private school in Ho Chi Minh City, Vietnam. We offer a comprehensive education program from kindergarten to high school. Our school is committed to providing a safe and nurturing environment for students to learn and grow. We believe that every child has the potential to succeed and we are dedicated to helping them reach their full potential. Our teachers are passionate about education and are dedicated to helping students achieve their goals. We offer a challenging curriculum that is designed to prepare students for success in college and beyond. Our school is a place where students can learn, grow, and thrive. We invite you to learn more about our school and see how we can help your child succeed.',
            'vi' => 'Chúng tôi là một trường tư thục tại Thành phố Hồ Chí Minh, Việt Nam. Chúng tôi cung cấp một chương trình giáo dục toàn diện từ mẫu giáo đến trung học. Trường của chúng tôi cam kết cung cấp một môi trường an toàn và nuôi dưỡng cho học sinh học tập và phát triển. Chúng tôi tin rằng mỗi đứa trẻ đều có tiềm năng để thành công và chúng tôi cam kết giúp họ đạt được tiềm năng đầy đủ của mình. Giáo viên của chúng tôi đam mê với giáo dục và cam kết giúp học sinh đạt được mục tiêu của mình. Chúng tôi cung cấp một chương trình học tập thách thức được thiết kế để chuẩn bị học sinh cho sự thành công trong đại học và xa hơn nữa. Trường của chúng tôi là nơi mà học sinh có thể học tập, phát triển và phát triển. Chúng tôi mời bạn tìm hiểu thêm về trường của chúng tôi và xem làm thế nào chúng tôi có thể giúp đỡ con bạn thành công.',
        ]);

        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->image = "images/moitruonghoctap.jpg";
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();

        //------------------------------------------------------------------------------------------------------------

        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'Our Philosophy',
            'vi' => 'Triết lý giáo dục',
        ]);

        $tabs->slug = "our-philosophy";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->key_page = "about-us-philosophy";
        $tabs->created_at = now();
        $tabs->updated_at = now();

        $tabs->save();


        $tabs_drop = new TabDrop();
        $tabs_drop->setTranslations('title', [
            'en' => 'Our Philosophy',
            'vi' => 'Triết lý giáo dục',
        ]);

        $tabs_drop->setTranslations('content', [
            'en' => 'Brighton Academy is a private school in Ho Chi Minh City, Vietnam. We offer a comprehensive education program from kindergarten to high school. Our school is committed to providing a safe and nurturing environment for students to learn and grow. We believe that every child has the potential to succeed and we are dedicated to helping them reach their full potential. Our teachers are passionate about education and are dedicated to helping students achieve their goals. We offer a challenging curriculum that is designed to prepare students for success in college and beyond. Our school is a place where students can learn, grow, and thrive. We invite you to learn more about our school and see how we can help your child succeed.',
            'vi' => 'Chúng tôi là một trường tư thục tại Thành phố Hồ Chí Minh, Việt Nam. Chúng tôi cung cấp một chương trình giáo dục toàn diện từ mẫu giáo đến trung học. Trường của chúng tôi cam kết cung cấp một môi trường an toàn và nuôi dưỡng cho học sinh học tập và phát triển. Chúng tôi tin rằng mỗi đứa trẻ đều có tiềm năng để thành công và chúng tôi cam kết giúp họ đạt được tiềm năng đầy đủ của mình. Giáo viên của chúng tôi đam mê với giáo dục và cam kết giúp học sinh đạt được mục tiêu của mình. Chúng tôi cung cấp một chương trình học tập thách thức được thiết kế để chuẩn bị học sinh cho sự thành công trong đại học và xa hơn nữa. Trường của chúng tôi là nơi mà học sinh có thể học tập, phát triển và phát triển. Chúng tôi mời bạn tìm hiểu thêm về trường của chúng tôi và xem làm thế nào chúng tôi có thể giúp đỡ con bạn thành công.',
        ]);

        $tabs_drop->tab_id = $tabs->id;
        $tabs_drop->bg_color = "#f5f5f5";
        $tabs_drop->image = "images/moitruonghoctap.jpg";
        $tabs_drop->created_at = now();
        $tabs_drop->updated_at = now();
        $tabs_drop->save();

        //------------------------------------------------------------------------------------------------------------
        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'component collapse',
            'vi' => 'component collapse',
        ]);

        $tabs->slug = "component-collapse";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->key_page = "about-us-collapse";
        $tabs->created_at = now();
        $tabs->updated_at = now();

        $tabs->save();


        $tabs_drop = new TabDrop();
        $tabs_drop->setTranslations('title', [
            'en' => 'component collapse',
            'vi' => 'component collapse',
        ]);

        $tabs_drop->setTranslations('content', [
            'en' => 'Brighton Academy is a private school in Ho Chi Minh City, Vietnam. We offer a comprehensive education program from kindergarten to high school. Our school is committed to providing a safe and nurturing environment for students to learn and grow. We believe that every child has the potential to succeed and we are dedicated to helping them reach their full potential. Our teachers are passionate about education and are dedicated to helping students achieve their goals. We offer a challenging curriculum that is designed to prepare students for success in college and beyond. Our school is a place where students can learn, grow, and thrive. We invite you to learn more about our school and see how we can help your child succeed.',
            'vi' => 'Chúng tôi là một trường tư thục tại Thành phố Hồ Chí Minh, Việt Nam. Chúng tôi cung cấp một chương trình giáo dục toàn diện từ mẫu giáo đến trung học. Trường của chúng tôi cam kết cung cấp một môi trường an toàn và nuôi dưỡng cho học sinh học tập và phát triển. Chúng tôi tin rằng mỗi đứa trẻ đều có tiềm năng để thành công và chúng tôi cam kết giúp họ đạt được tiềm năng đầy đủ của mình. Giáo viên của chúng tôi đam mê với giáo dục và cam kết giúp học sinh đạt được mục tiêu của mình. Chúng tôi cung cấp một chương trình học tập thách thức được thiết kế để chuẩn bị học sinh cho sự thành công trong đại học và xa hơn nữa. Trường của chúng tôi là nơi mà học sinh có thể học tập, phát triển và phát triển. Chúng tôi mời bạn tìm hiểu thêm về trường của chúng tôi và xem làm thế nào chúng tôi có thể giúp đỡ con bạn thành công.',
        ]);

        $tabs_drop->tab_id = $tabs->id;
        $tabs_drop->image = "images/moitruonghoctap.jpg";
        $tabs_drop->created_at = now();
        $tabs_drop->updated_at = now();
        $tabs_drop->save();


        //------------------------------------------------------------------------------------------------------------
        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'School board message',
            'vi' => 'Thông điệp của Ban Giám Hiệu',
        ]);
        $tabs->slug = "school-board-message";
        $tabs->key_page = "about-us";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();
        $tabs->save();

        $tabs_img_content = new TabImgContent();
        $tabs_img_content->setTranslations('title', [
            'en' => 'Message from the School Board',
            'vi' => 'Thông điệp của Ban Giám Hiệu',
        ]);
        $tabs_img_content->setTranslations('content', [
            'en' => 'Brighton Academy is a private school in Ho Chi Minh City, Vietnam. We offer a comprehensive education program from kindergarten to high school. Our school is committed to providing a safe and nurturing environment for students to learn and grow. We believe that every child has the potential to succeed and we are dedicated to helping them reach their full potential. Our teachers are passionate about education and are dedicated to helping students achieve their goals. We offer a challenging curriculum that is designed to prepare students for success in college and beyond. Our school is a place where students can learn, grow, and thrive. We invite you to learn more about our school and see how we can help your child succeed.',
            'vi' => 'Chúng tôi là một trường tư thục tại Thành phố Hồ Chí Minh, Việt Nam. Chúng tôi cung cấp một chương trình giáo dục toàn diện từ mẫu giáo đến trung học. Trường của chúng tôi cam kết cung cấp một môi trường an toàn và nuôi dưỡng cho học sinh học tập và phát triển. Chúng tôi tin rằng mỗi đứa trẻ đều có tiềm năng để thành công và chúng tôi cam kết giúp họ đạt được tiềm năng đầy đủ của mình. Giáo viên của chúng tôi đam mê với giáo dục và cam kết giúp học sinh đạt được mục tiêu của mình. Chúng tôi cung cấp một chương trình học tập thách thức được thiết kế để chuẩn bị học sinh cho sự thành công trong đại học và xa hơn nữa. Trường của chúng tôi là nơi mà học sinh có thể học tập, phát triển và phát triển. Chúng tôi mời bạn tìm hiểu thêm về trường của chúng tôi và xem làm thế nào chúng tôi có thể giúp đỡ con bạn thành công.',
        ]);
        $tabs_img_content->tab_id = $tabs->id;
        $tabs_img_content->image = "images/moitruonghoctap.jpg";
        $tabs_img_content->created_at = now();
        $tabs_img_content->updated_at = now();
        $tabs_img_content->save();

        $tabs_drop = new TabDrop();
        $tabs_drop->tab_id = $tabs->id;
        $tabs_drop->setTranslations('title', [
            'en' => 'Message from the School Board',
            'vi' => 'Thông điệp của Ban Giám Hiệu',
        ]);
        $tabs_drop->setTranslations('content', [
            'en' => 'Brighton Academy is a private school in Ho Chi Minh City, Vietnam. We offer a comprehensive education program from kindergarten to high school. Our school is committed to providing a safe and nurturing environment for students to learn and grow. We believe that every child has the potential to succeed and we are dedicated to helping them reach their full potential. Our teachers are passionate about education and are dedicated to helping students achieve their goals. We offer a challenging curriculum that is designed to prepare students for success in college and beyond. Our school is a place where students can learn, grow, and thrive. We invite you to learn more about our school and see how we can help your child succeed.',
            'vi' => 'Chúng tôi là một trường tư thục tại Thành phố Hồ Chí Minh, Việt Nam. Chúng tôi cung cấp một chương trình giáo dục toàn diện từ mẫu giáo đến trung học. Trường của chúng tôi cam kết cung cấp một môi trường an toàn và nuôi dưỡng cho học sinh học tập và phát triển. Chúng tôi tin rằng mỗi đứa trẻ đều có tiềm năng để thành công và chúng tôi cam kết giúp họ đạt được tiềm năng đầy đủ của mình. Giáo viên của chúng tôi đam mê với giáo dục và cam kết giúp học sinh đạt được mục tiêu của mình. Chúng tôi cung cấp một chương trình học tập thách thức được thiết kế để chuẩn bị học sinh cho sự thành công trong đại học và xa hơn nữa. Trường của chúng tôi là nơi mà học sinh có thể học tập, phát triển và phát triển. Chúng tôi mời bạn tìm hiểu thêm về trường của chúng tôi
                và xem làm thế nào chúng tôi có thể giúp đỡ con bạn thành công.'
        ]);
        $tabs_drop->image = "images/moitruonghoctap.jpg";
        $tabs_drop->created_at = now();
        $tabs_drop->updated_at = now();
        $tabs_drop->save();
    }
}
