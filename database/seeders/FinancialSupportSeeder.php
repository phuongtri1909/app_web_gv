<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\FinancialSupport;

class FinancialSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $financialSupports = [
            [
                'name' => json_encode([
                    'en' => 'Manufacturer Sponsorship',
                    'vi' => 'Tài trợ nhà sản xuất'
                ]),
                'slug' => Str::slug('Tài trợ nhà sản xuất'),
                'avt_financial_support' => null,
            ],
            [
                'name' => json_encode([
                    'en' => 'Flexible Business Loan',
                    'vi' => 'Tài trợ vốn linh hoạt'
                ]),
                'slug' => Str::slug('Tài trợ vốn linh hoạt'),
                'avt_financial_support' => null,
            ],
            [
                'name' => json_encode([
                    'en' => 'Distributor Sponsorship',
                    'vi' => 'Tài trợ nhà phân phối'
                ]),
                'slug' => Str::slug('Tài trợ nhà phân phối'),
                'avt_financial_support' => null,
            ],
            [
                'name' => json_encode([
                    'en' => 'Electronic Banking Services',
                    'vi' => 'Dịch vụ ngân hàng điện tử'
                ]),
                'slug' => Str::slug('Dịch vụ ngân hàng điện tử'),
                'avt_financial_support' => null,
            ],
            [
                'name' => json_encode([
                    'en' => 'International Money Transfer',
                    'vi' => 'Chuyển tiền quốc tế'
                ]),
                'slug' => Str::slug('Chuyển tiền quốc tế'),
                'avt_financial_support' => null,
            ],
        ];

        foreach ($financialSupports as $support) {
            FinancialSupport::create($support);
        }
    }
}
