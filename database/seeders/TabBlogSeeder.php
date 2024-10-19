<?php

namespace Database\Seeders;

use App\Models\Tab;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'News',
            'vi' => 'Tin tức',
        ]);

        $tabs->slug = "blogs";
        $tabs->key_page = "blog";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();

        $tabs->save();
    }
}
