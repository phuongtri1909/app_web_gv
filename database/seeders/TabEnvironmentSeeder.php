<?php

namespace Database\Seeders;

use App\Models\Tab;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabEnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tabs = new Tab();
        $tabs->setTranslations('title', [
            'en' => 'Life at Brighton',
            'vi' => 'Môi trường học tập',
        ]);

        $tabs->slug = "learn-environment";
        $tabs->key_page = "environment";
        $tabs->banner = "images/moitruonghoctap.jpg";
        $tabs->created_at = now();
        $tabs->updated_at = now();

        $tabs->save();
    }
}
