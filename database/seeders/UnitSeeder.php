<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unites = [
            [
                'unit_name' => 'Quận gò vấp',
                'unit_code' => 'QGV',
                'unit_status' => 'active',
            ],
            [
                'unit_name' => 'Phường 17',
                'unit_code' => 'P17',
                'unit_status' => 'active',
            ]
        ];

        foreach ($unites as $unit) {
            \App\Models\Unit::create($unit);
        }
    }
}
