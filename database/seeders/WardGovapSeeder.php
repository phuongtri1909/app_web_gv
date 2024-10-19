<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardGovapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ward_govap')->insert([
            ['name' => 'Phường 1'],
            ['name' => 'Phường 3'],
            ['name' => 'Phường 4'],
            ['name' => 'Phường 5'],
            ['name' => 'Phường 6'],
            ['name' => 'Phường 7'],
            ['name' => 'Phường 8'],
            ['name' => 'Phường 9'],
            ['name' => 'Phường 10'],
            ['name' => 'Phường 11'],
            ['name' => 'Phường 12'],
            ['name' => 'Phường 13'],
            ['name' => 'Phường 14'],
            ['name' => 'Phường 15'],
            ['name' => 'Phường 16'],
            ['name' => 'Phường 17'],
        ]);
    }
}
