<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banners')->insert([
            [
                'path' => '/images/vd.mp4',
                'key_page' => 'key_home',
                'active' => 'yes',
                'thumbnail' => '/images/bs.png',
            ]
        ]);
    }
}
