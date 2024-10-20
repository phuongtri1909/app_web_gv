<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $business = new Business();
            $business->business_code = '0318155069';
            $business->business_name = 'Cty TNHH TM DV ĐẦU TƯ SEN VIỆT';
            $business->representative_name = 'NGUYỄN THỊ DUYÊN';
            $business->phone_number = '0902386386';
            $business->fax_number = '0318155069';
            $business->address = '174-174A -174B Huỳnh Thị Hai, P. Tân Chánh Hiệp,Q12, Tp HCM';
            $business->ward_id = 1;
            $business->email = 'Senviet@nppsenviet.vn';
            $business->category_business_id = 1;
            $business->business_license = null;
            $business->social_channel = "https://nppsenviet.com";
            $business->description = "Nghành nghề kinh doanh: 
1. chuyên phân phối sỹ và lẻ các mặt hàng tiêu dùng thiết yếu cho Hệ thống Nhà Hàng, cơ quan xí nghiệp, bếp ăn, quà tặng công đoàn
2. Hệ thống siêu thị Sevi Mart với tiêu chí: SIÊU THỊ VIỆT - GIÁ TRỊ CHO NGƯỜI VIỆT";
            $business->avt_businesses = "images/logoSENVIET.jpg";
            $business->status = 'approved';
            $business->created_at = now();
            $business->updated_at = now();

            $business->save();

            $user = $business->user()->create([
                'username' => '0318155069',
                'full_name' => 'Cty TNHH TM DV ĐẦU TƯ SEN VIỆT',
                'avatar' => 'images/logoSENVIET.jpg',
                'email' => 'Senviet@nppsenviet.vn',
                'password' => Hash::make('0318155069'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productBusiness = $business->products()->create([
                'category_product_id' => 5,
                'name_product' => 'DẦU ĂN CAO CẤP VẠN THỌ 1L X 12 CHAI',
                'slug' => 'dau-an-cao-cap-van-tho-1l-x-12-chai',
                'description' => null,
                'price' => 500500,
                'product_story' => null,
                'product_avatar' => 'images/dau-an-cao-cap-van-tho-1l-x-12-chai.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productImage = ProductImage::create([
                'product_id' => $productBusiness->id,
                'image' => 'images/dau-an-cao-cap-van-tho-1l-x-12-chai.webp',
                'thumbnail' => 'images/dau-an-cao-cap-van-tho-1l-x-12-chai.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}