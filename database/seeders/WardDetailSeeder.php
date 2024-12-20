<?php

namespace Database\Seeders;

use App\Models\WardDetail;
use App\Models\WardGovap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WardDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $wardGovap = WardGovap::where('slug', 'phuong-17')->first();

         if ($wardGovap) {
             WardDetail::create([
                 'ward_govap_id' => $wardGovap->id,
                 'area' => 115.96,
                 'total_households' => 14332,
                 'created_at' => now(),
                 'updated_at' => now(),
             ]);
         } else {
             echo "Không tìm thấy ward_govap với slug 'phuong-17'. Hãy kiểm tra dữ liệu của bảng ward_govap.\n";
         }
    }
}
