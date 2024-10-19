<?php

namespace Database\Seeders;

use App\Models\Tab;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EditTabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'Programs content',
            'vi' => 'Nội dung chương trình',
        ]);
        $tabs->slug = "programs-content";
        $tabs->key_page = "programs-content";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();
        $tabs->save();

        //-----------------------------------------------------------------------------------

        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'Advisory board',
            'vi' => 'Ban cố vấn',
        ]);
        $tabs->slug = "advisory-board";
        $tabs->key_page = "advisory-board";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();
        $tabs->save();
    }
}
