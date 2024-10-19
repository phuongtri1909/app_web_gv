<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tab;
class TabsParentNewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tab1 = new Tab();
        $tab1->setTranslations('title', [
            'en' => 'Benefits of studying at Brighton Academy',
            'vi' => 'Lợi ích khi con học tại Brighton Academy',
        ]);
        $tab1->slug = "loi-ich-khi-con-hoc-tai-brighton-academy";
        $tab1->key_page = "parent";
        $tab1->banner = "images/moitruonghoctap.jpg";
        $tab1->created_at = now();
        $tab1->updated_at = now();
        $tab1->save();

        $tab2 = new Tab();
        $tab2->setTranslations('title', [
            'en' => 'Strategies and Tips',
            'vi' => 'Chiến lược và mẹo',
        ]);
        $tab2->slug = "chien-luoc-va-meo";
        $tab2->key_page = "parent";
        $tab2->banner = "images/moitruonghoctap.jpg";
        $tab2->created_at = now();
        $tab2->updated_at = now();
        $tab2->save();

        $tab3 = new Tab();
        $tab3->setTranslations('title', [
            'en' => 'Our Activities and Events',
            'vi' => 'Các hoạt động và sự kiện chúng tôi',
        ]);
        $tab3->slug = "cac-hoat-dong-va-su-kien-chung-toi";
        $tab3->key_page = "parent";
        $tab3->banner = "images/moitruonghoctap.jpg";
        $tab3->created_at = now();
        $tab3->updated_at = now();
        $tab3->save();
    }
}
