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
                'name' => [
                    'en' => 'Manufacturer Sponsorship',
                    'vi' => 'Tài trợ nhà sản xuất'
                ],
                'slug' => Str::slug('Tài trợ nhà sản xuất'),
                'avt_financial_support' => '/images/Banner IZIBANKBIZ 200x200.jpg',
            ],
            [
                'name' => [
                    'en' => 'Flexible Business Loan',
                    'vi' => 'Tài trợ vốn linh hoạt'
                ],
                'slug' => Str::slug('Tài trợ vốn linh hoạt'),
                'avt_financial_support' => '/images/Vayvonkinhdoanh-200x200.jpg',
            ],
            [
                'name' => [
                    'en' => 'Distributor Sponsorship',
                    'vi' => 'Tài trợ nhà phân phối'
                ],
                'slug' => Str::slug('Tài trợ nhà phân phối'),
                'avt_financial_support' => '/images/Banner NPP KHDN 200x200px.jpg',
            ],
            [
                'name' => [
                    'en' => 'Electronic Banking Services',
                    'vi' => 'Dịch vụ ngân hàng điện tử'
                ],
                'slug' => Str::slug('Dịch vụ ngân hàng điện tử'),
                'avt_financial_support' => '/images/Banner IZIBANKBIZ 200x200.jpg',
            ],
            [
                'name' => [
                    'en' => 'International Money Transfer',
                    'vi' => 'Chuyển tiền quốc tế'
                ],
                'slug' => Str::slug('Chuyển tiền quốc tế'),
                'avt_financial_support' => '/images/Chuyentienquocte-200x200-01.jpg',
            ],
        ];

        foreach ($financialSupports as $support) {
            $financialSupport = new FinancialSupport();

            $financialSupport->setTranslations('name', $support['name']);

            $financialSupport->slug = $support['slug'];
            $financialSupport->avt_financial_support = $support['avt_financial_support'];

            $financialSupport->save();
        }
    }

}
