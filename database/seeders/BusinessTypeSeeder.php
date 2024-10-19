<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        DB::table('category_business')->insert([
            ['name' => 'Công ty trách nhiệm hữu hạn một thành viên'],
            ['name' => 'Công ty trách nhiệm hữu hạn hai thành viên trở lên'],
            ['name' => 'Công ty cổ phần'],
            ['name' => 'Công ty hợp danh'],
            ['name' => 'Doanh nghiệp tư nhân'],
        ]);
    }
}
