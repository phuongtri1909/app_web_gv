<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $language = new Language();
        $language->setTranslations('name', [
            'en' => 'English',
            'vi' => 'Tiếng Anh',
        ]);
        $language->locale = 'en';
        $language->flag = 'images/en.png';
        $language->created_at = now();
        $language->updated_at = now();
        $language->save();

        $language = new Language();
        $language->setTranslations('name', [
            'en' => 'Vietnamese',
            'vi' => 'Tiếng Việt',
        ]);
        $language->locale = 'vi';
        $language->flag = 'images/vi.png';
        $language->created_at = now();
        $language->updated_at = now();
        $language->save();
    }
}
