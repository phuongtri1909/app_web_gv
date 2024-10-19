<?php

namespace Database\Seeders;

use App\Models\Tab;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabForParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'For Parents',
            'vi' => 'Dành cho phụ huynh',
        ]);

        $tabs->slug = "for-parent";
        $tabs->key_page = "parent";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();

        $tabs->save();
    }
}
