<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WardGovap;
use Illuminate\Support\Str;

class UpdateSlugForWardGovapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wards = WardGovap::all();

        foreach ($wards as $ward) {
            $ward->slug = Str::slug($ward->name); // Tạo slug từ name
            $ward->save();
        }
    }
}
