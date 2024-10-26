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
            //             $business = new Business();
            //             $business->business_code = '0318155069';
            //             $business->business_name = 'Cty TNHH TM DV ĐẦU TƯ SEN VIỆT';
            //             $business->representative_name = 'NGUYỄN THỊ DUYÊN'; //người đại diện
            // 	        $business->birth_year = '1998'; //năm sinh người đại diện
            //             $business->gender = 'female'; //('male', 'female', 'other')
            // 	        $business->address = '189/4 tăng nhơn phú'; //(địa chỉ người đại diện)
            //             $business->phone_number = '0902386386';
            //             $business->fax_number = '0318155069';
            //             $business->business_address = '174-174A -174B Huỳnh Thị Hai, P. Tân Chánh Hiệp,Q12, Tp HCM';
            //             $business->ward_id = 1; //phường
            //             $business->email = 'Senviet@nppsenviet.vn';
            //             $business->category_business_id = 1; // danh mục business
            //             $business->business_license = null;  // giấy phép kinh doanh (file pdf nếu có)
            //             $business->social_channel = "https://nppsenviet.com";
            //             $business->description = "Nghành nghề kinh doanh: 
            // 1. chuyên phân phối sỹ và lẻ các mặt hàng tiêu dùng thiết yếu cho Hệ thống Nhà Hàng, cơ quan xí nghiệp, bếp ăn, quà tặng công đoàn
            // 2. Hệ thống siêu thị Sevi Mart với tiêu chí: SIÊU THỊ VIỆT - GIÁ TRỊ CHO NGƯỜI VIỆT";
            //             $business->avt_businesses = "images/logoSENVIET.jpg";
            //             $business->status = 'approved'; //('pending', 'approved', 'rejected')
            //             $business->created_at = now();
            //             $business->updated_at = now();

            //             $business->save();

            //             $user = $business->user()->create([
            //                 'username' => '0318155069',
            //                 'full_name' => 'Cty TNHH TM DV ĐẦU TƯ SEN VIỆT',
            //                 'avatar' => 'images/logoSENVIET.jpg',
            //                 'email' => 'Senviet@nppsenviet.vn',
            //                 'password' => Hash::make('0318155069'),
            //                 'created_at' => now(),
            //                 'updated_at' => now(),
            //             ]);

            //             $productBusiness = $business->products()->create([
            //                 'category_product_id' => 5,
            //                 'name_product' => 'DẦU ĂN CAO CẤP VẠN THỌ 1L X 12 CHAI',
            //                 'slug' => 'dau-an-cao-cap-van-tho-1l-x-12-chai',
            //                 'description' => null,
            //                 'price' => 500500,
            //                 'product_story' => null,
            //                 'product_avatar' => 'images/dau-an-cao-cap-van-tho-1l-x-12-chai.webp',
            //                 'created_at' => now(),
            //                 'updated_at' => now(),
            //             ]);

            //             $productImage = ProductImage::create([
            //                 'product_id' => $productBusiness->id,
            //                 'image' => 'images/dau-an-cao-cap-van-tho-1l-x-12-chai.webp',
            //                 'thumbnail' => 'images/dau-an-cao-cap-van-tho-1l-x-12-chai.webp',
            //                 'created_at' => now(),
            //                 'updated_at' => now(),
            //             ]);


                        $business = new Business();
                        $business->business_code = '0302887564';
                        $business->business_name = 'CÔNG TY CỔ PHẦN TẬP ĐOÀN ĐẦU TƯ - THƯƠNG MẠI VÀ XÂY DỰNG VÂN KHÁNH';
                        $business->representative_name = 'TRỊNH VĂN KHANH'; //người đại diện
                        $business->birth_year = '1998'; //năm sinh người đại diện
                        $business->gender = 'male'; //('male', 'female', 'other')
                        $business->address = 'O4 Quang Trung, Phường 11, Quận Gò Vấp, Thành phố Hồ Chí Minh, Việt Nam'; //(địa chỉ người đại diện)
                        $business->phone_number = '0983939474';
                        $business->fax_number = '';
                        $business->business_address = 'O4 Quang Trung, Phường 11, Quận Gò Vấp, Thành phố Hồ Chí Minh, Việt Nam';
                        $business->ward_id = 10; //phường
                        $business->email = 'info@vankhanhgroup.com';
                        $business->category_business_id = 1; // danh mục business
                        $business->business_license = null;  // giấy phép kinh doanh (file pdf nếu có)
                        $business->social_channel = "https://vankhanhgroup.com/";
                        $business->description = 'Kính gửi Quý Khách hàng và Đối tác;
            Được thành lập từ năm 2003, sau 20 năm hình thành và phát triển TẬP ĐOÀN VÂN KHÁNH (VKG) đã khẳng định thương hiệu là một trong những nhà thầu thi công hệ thống cơ điện (MEP) uy tín nhất hiện nay. Với nhiều năm kinh nghiệm trong lĩnh vực xây dựng, kỹ thuật, cơ - điện công trình, hiện nay chúng tôi mở rộng thêm ngành nghề khác: lắp đặt thang máy hiệu SANKA; hệ thống điện năng lượng mặt trời (Solar), thiết kế hệ thống PCCC với quy mô khác nhau cho các Trung tâm thương mại, căn hộ, khách sạn, khu nghỉ dưỡng, khu phát triển nhà ở, nhà máy công nghiệp…trên khắp đất nước.

            TẬP ĐOÀN VÂN KHÁNH đã luôn nỗ lực, không ngừng phấn đấu để đóng góp vào sự phát triển chung của nền kinh tế và xã hội. Thành công của chúng tôi bắt nguồn từ sự đam mê nhiệt huyết cùng với tinh thần trách nhiệm của một đội ngũ đoàn kết và phong cách chuyên nghiệp. TẬP ĐOÀN VÂN KHÁNH tự tin đáp ứng các yêu cầu của khách hàng. 
            Với phương châm "AN TOÀN - CHẤT LƯỢNG - TIẾN ĐỘ", chúng tôi mong có nhiều cơ hội để phục vụ Quý Khách .
            Trân trọng kính chào.
                 Chủ tịch HĐQT - Tổng Giám đốc
                          TRỊNH VĂN KHANH';
                        $business->avt_businesses = "images/business/logo-van-khanh-932023-9152.png";
                        $business->status = 'approved'; //('pending', 'approved', 'rejected')
                        $business->created_at = now();
                        $business->updated_at = now();

                        $business->save();

                        $user = $business->user()->create([
                            'username' => '0302887564',
                            'full_name' => 'CÔNG TY CỔ PHẦN TẬP ĐOÀN ĐẦU TƯ - THƯƠNG MẠI VÀ XÂY DỰNG VÂN KHÁNH',
                            'avatar' => 'images/business/logo-van-khanh-932023-9152.png',
                            'email' => 'info@vankhanhgroup.com',
                            'password' => Hash::make('0302887564'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        //------------------------

                        $business = new Business();
                        $business->business_code = '0303134669';
                        $business->business_name = 'CÔNG TY TNHH KỸ THUẬT CÔNG NGHỆ ÁNH DƯƠNG SÀI GÒN';
                        $business->representative_name = 'TRẦN HOÀI NAM'; //người đại diện
                        $business->birth_year = '1998'; //năm sinh người đại diện
                        $business->gender = 'male'; //('male', 'female', 'other')
                        $business->address = '123 Hoàng Hoa Thám,  phường 13, quận Tân Bình, Tp. Hồ Chí Minh'; //(địa chỉ người đại diện)
                        $business->phone_number = ' 02822444980';
                        $business->fax_number = '';
                        $business->business_address = '123 Hoàng Hoa Thám,  phường 13, quận Tân Bình, Tp. Hồ Chí Minh';
                        $business->ward_id = 10; //phường
                        $business->email = 'saigonsunlight@yahoo.com';
                        $business->category_business_id = 1; // danh mục business
                        $business->business_license = null;  // giấy phép kinh doanh (file pdf nếu có)
                        $business->social_channel = "www.saigonsunlight.com";
                        $business->description = 'Lắp đặt hệ thống xây dựng khác (không gia công cơ  khí, tái chế phế thải, xi, mạ  điện tại trụ sở)
            Bán buôn máy móc, thiết bị và phụ tùng máy móc  khác.
            Bán buôn vật liệu, thiết bị lắp đặt khác trong xây  dựng
            Sửa chữa thiết bị điện  (không gia công cơ  khí, tái  chế phế thải, xi, mạ điện  tại trụ sở)
            Lắp đặt hệ thống cấp thóat nước, lò sưởi và điều hòa không khí (không gia công cơ khí, tái chế phế thải, xi, mạ điện tại trụ sở)
            Họat động kiến trúc và tư vấn kỷ thuật có liên quan - chi tiết: Tư vấn lập dự án đầu  tư; Tư vấn Thiết kế kỹ thuật; Tư vấn giám sát công trình xây dựng (dân dụng, công nghiệp, giao thông, thủy lợi, hạ tầng kỹ thuật); Tư vấn thiết kế máy móc và thiết  bị
            Gia công cơ khí, xử lý và tráng phủ kim lọai (không họat động tại trụ   sở)
            Sản xuất Palastic và cao su tổng hợp dạng nguyên sinh (trừ tái chế phế thải, luyện cán cao su tại trụ sở)
            Xây dựng công trình kỹ thuật dân dụng khác - chi tiết: Xây dựng công trình dân dụng; công nghiệp; công trình cáp ngầm – cáp treo và  cáp quang.; Xây dựng công  trình đường thuỷ, bến cảng và các công trình trên sông, các cảng du lịch, cửa   cống...
            Lắp đặt hệ thống điện (không gia công cơ khí, tái chế phế thải, xi, mạ điện tại trụ   sở)
            Nghiên cứu thị trường và thăm dò dư  luận
            Tổ chức giới thiệu và xúc tiến thương  mại
            Sản xuất môtơ, máy phát, biến thế điện, thiết bị phân phối và điều khiển điện  (không sản xuất tại trụ sở)
            Sản xuất máy máy chuyên dụng khác -chi tiết: Sản xuất động cơ, tua bin; sản xuất máy sản xuất vật liệu xây dựng (không sản xuất tại trụ  sở)
            Sửa chữa máy móc thiết bị (không gia công cơ khí, tái chế phế thải, xi, mạ điện tại trụ sở)
            Hoạt động xây dựng chuyên dụng khác - chi tiết: Dỡ bỏ ống khói và các nồi hơi công nghiệp
            Vận tải hàng hóa bằng đường bộ
            Sản xuất máy nông nghiệp và lâm nghiệp (không sản xuất tại trụ  sở)
            Sản xuất thiết bị điện khác - chi tiết: Sản xuất tụ điện, điện    trở, và các thiết bị tương  tự, máy gia tốc (không gia công cơ khí, tái chế phế thải, xi, mạ điện tại trụ  sở)
            Lắp đặt máy móc thiết bị công nghiệp (không gia công cơ khí, tái chế phế thải, xi, mạ điện tại trụ sở)
            Bán buôn đồ dùng khác cho gia đình - chi tiết: Bán buôn vali, cặp, túi, ví, hàng da   và giả da khác; Bán buôn đồ điện gia dụng, đèn và bộ đèn  điện.
            Bán buôn kim lọai và quặng kim lọai
            Bán buôn chuyên doanh khác chưa được phân vào đâu - chi tiết: Bán buôn hoá chất công nghiệp: anilin, mực in, tinh dầu, khí công nghiệp, keo hoá học, chất màu, nhựa tổng hợp, methanol, parafin, dầu thơm và hương liệu, sôđa, muối công nghiệp, axít và lưu huỳnh; cao su nguyên liệu, phụ liệu may mặc và  giày  dép
            Vận tải hành khách bằng đường bộ
            Xây dựng công trình đường sắt và đường bộ - chi tiết: Xây dựng đường cao tốc, đường ô tô, đường phố, các loại đường khác và đường cho  người đi bộ;  Các  công việc bề mặt trên đường phố, đường bộ, đường cao tốc, cầu  cống ( Rải nhựa đường;  Sơn đường và các loại sơn khác; Lắp đặt các đường chắn, các dấu hiệu giao thông và các thứ tương tự); Xây dựng cầu, (bao gồm  cầu  cho  đường  cao  tốc);  Xây dựng đường ống; Xây dựng đường sắt và đường ngầm; Xây dựng đường băng máy  bay.
            Xây dựng công trình công ích - chi tiết: Xây dựng trạm và đường dây tải điện, trạm biến thế đến 35KV - 110KV - 220KV - 500KV; Xây dựng đường ống và hệ thống  nước  {bao  gồm hệ thống tưới  tiêu  (kênh),  Các bể chứa};  Xây dựng  các công   trình  {Hệ thống nước thải (bao gồm  cả sửa chữa),  Nhà máy xử lý nước thải, Các trạm  bơm}
            Chuẩn bị mặt bằng: San lấp mặt bằng
            Xây dựng công trình kỹ thuật; Tư vấn đầu tư, chuyển giao công nghệ. Lắp đặt hệ thống bơm, ống nước, điều hòa không khí. Mua bán vật tư ngành điện. Sản xuất máy móc chuyên dụng. Sản xuất giày dép (không luyện cán cao su, thuộc gia, tái chế phế thải). Sàn xuất các sản phẩm từ bọt Polyxêtilen (không sản xuất tại trụ sở). Mua bán  hóa chất (trừ hóa chất có tính đọc hại  mạnh)';
                        $business->avt_businesses = "images/business/Cong-Ty-T_636070293101453690.png";
                        $business->status = 'approved'; //('pending', 'approved', 'rejected')
                        $business->created_at = now();
                        $business->updated_at = now();

                        $business->save();

                        $user = $business->user()->create([
                            'username' => '0303134669',
                            'full_name' => 'CÔNG TY TNHH KỸ THUẬT CÔNG NGHỆ ÁNH DƯƠNG SÀI GÒN',
                            'avatar' => 'images/business/Cong-Ty-T_636070293101453690.png',
                            'email' => 'saigonsunlight@yahoo.com',
                            'password' => Hash::make('0303134669'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

            //---------------------
            $business = new Business();
                        $business->business_code = '0316391536';
                        $business->business_name = 'CÔNG TY TNHH SẢN XUẤT THƯƠNG MẠI DỊCH VỤ YẾN SÀO HÒA LÊ';
                        $business->representative_name = 'LÊ THỊ HÒA'; //người đại diện
            	        $business->birth_year = '1998'; //năm sinh người đại diện
                        $business->gender = 'female'; //('male', 'female', 'other')
            	        $business->address = '25/12/23 Bùi Quang Là, Phường 12, Quận Gò Vấp, Thành phố Hồ Chí Minh, Việt Nam'; //(địa chỉ người đại diện)
                        $business->phone_number = '0983579329';
                        $business->fax_number = '';
                        $business->business_address = '25/12/23 Bùi Quang Là, Phường 12, Quận Gò Vấp, Thành phố Hồ Chí Minh, Việt Nam';
                        $business->ward_id = 11; //phường
                        $business->email = 'yensaohoale@gmail.com';
                        $business->category_business_id = 1; // danh mục business
                        $business->business_license = null;  // giấy phép kinh doanh (file pdf nếu có)
                        $business->social_channel = "";
                        $business->description = "Bán buôn thực phẩm
            Chi tiết: Bán buôn tổ chim yến thô, tổ chim yến đã qua chế biến";
                        $business->avt_businesses = "images/business/logo-yen-xao-hoa-le.jpg";
                        $business->status = 'approved'; //('pending', 'approved', 'rejected')
                        $business->created_at = now();
                        $business->updated_at = now();

                        $business->save();

                        $user = $business->user()->create([
                            'username' => '0316391536',
                            'full_name' => 'CÔNG TY TNHH SẢN XUẤT THƯƠNG MẠI DỊCH VỤ YẾN SÀO HÒA LÊ',
                            'avatar' => 'images/business/logo-yen-xao-hoa-le.jpg',
                            'email' => 'yensaohoale@gmail.com',
                            'password' => Hash::make('0316391536'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $productBusiness = $business->products()->create([
                            'category_product_id' => 5,
                            'name_product' => 'Tổ yến thô',
                            'slug' => 'to-yen-tho',
                            'description' => null,
                            'price' => 0,
                            'product_story' => null,
                            'product_avatar' => 'images/business-products/z5946154349665_8a1b14b5c1795a2d07b4029400510146.jpg',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $productImage = ProductImage::create([
                            'product_id' => $productBusiness->id,
                            'image' => 'images/business-products/z5946136192624_404c0f25220037de108d180c7e4e5a63.jpg',
                            'thumbnail' => 'images/business-products/z5946136192624_404c0f25220037de108d180c7e4e5a63.jpg',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $productImage = ProductImage::create([
                            'product_id' => $productBusiness->id,
                            'image' => 'images/business-products/z5946154349665_8a1b14b5c1795a2d07b4029400510146.jpg',
                            'thumbnail' => 'images/business-products/z5946154349665_8a1b14b5c1795a2d07b4029400510146.jpg',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        //------

                        $productBusiness = $business->products()->create([
                            'category_product_id' => 5,
                            'name_product' => 'Tổ yến xuất khẩu',
                            'slug' => 'to-yen-xuat-khau',
                            'description' => null,
                            'price' => 0,
                            'product_story' => null,
                            'product_avatar' => 'images/business-products/z5946154352333_41ecfde02707afbdb4160e0d054b31ee.jpg',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $productImage = ProductImage::create([
                            'product_id' => $productBusiness->id,
                            'image' => 'images/business-products/z5946154352333_41ecfde02707afbdb4160e0d054b31ee.jpg',
                            'thumbnail' => 'images/business-products/z5946154352333_41ecfde02707afbdb4160e0d054b31ee.jpg',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);


                        //-------------------------
                        $business = new Business();
                        $business->business_code = '0303159159';
                        $business->business_name = 'CÔNG TY TNHH SẢN XUẤT - THƯƠNG MẠI MEBIPHA';
                        $business->representative_name = 'HUỲNH CÔNG TUẤNLÂM THÚY ÁI'; //người đại diện
            	        $business->birth_year = '1998'; //năm sinh người đại diện
                        $business->gender = 'female'; //('male', 'female', 'other')
            	        $business->address = '18/8A Đường 143 Quang Trung, Phường 14, Quận Gò Vấp,  Thành phố Hồ Chí Minh, Việt Nam'; //(địa chỉ người đại diện)
                        $business->phone_number = '02854273128';
                        $business->fax_number = '';
                        $business->business_address = '18/8A Đường 143 Quang Trung, Phường 14, Quận Gò Vấp,  Thành phố Hồ Chí Minh, Việt Nam';
                        $business->ward_id = 11; //phường
                        $business->email = 'mebipha@gmail.com';
                        $business->category_business_id = 1; // danh mục business
                        $business->business_license = null;  // giấy phép kinh doanh (file pdf nếu có)
                        $business->social_channel = "https://mebipha.com/";
                        $business->description = "MEBIPHA là nhà cung cấp hàng đầu các giải pháp chuyên nghiệp bảo vệ sức khỏe và dinh dưỡng vật nuôi.

            Trải qua 20 năm phát triển, với công nghệ tiên tiến, nhà máy đạt chuẩn GMP WHO, MEBIPHA tự tin mang đến cho nhà chăn nuôi trong nước và nước ngoài những sản phẩm tốt và hiệu quả nhất";
                        $business->avt_businesses = "images/business/logo-final_blue-285x300.png";
                        $business->status = 'approved'; //('pending', 'approved', 'rejected')
                        $business->created_at = now();
                        $business->updated_at = now();

                        $business->save();

                        $user = $business->user()->create([
                            'username' => '0303159159',
                            'full_name' => 'CÔNG TY TNHH SẢN XUẤT - THƯƠNG MẠI MEBIPHA',
                            'avatar' => 'images/business/logo-final_blue-285x300.png',
                            'email' => 'mebipha@gmail.com',
                            'password' => Hash::make('0303159159'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);


            $business = new Business();
            $business->business_code = '1700169765';
            $business->business_name = 'NGÂN HÀNG TMCP QUỐC DÂN( NCB) - CN CỘNG HÒA';
            $business->representative_name = 'BÙI THỊ THANH HƯƠNG'; //người đại diện
            $business->birth_year = '1998'; //năm sinh người đại diện
            $business->gender = 'female'; //('male', 'female', 'other')
            $business->address = '18H Cộng Hòa, Phường 4, Quận Tân Bình, TP.HCM'; //(địa chỉ người đại diện)
            $business->phone_number = '0786338339';
            $business->fax_number = '';
            $business->business_address = '18H Cộng Hòa, Phường 4, Quận Tân Bình, TP.HCM';
            $business->ward_id = 3; //phường
            $business->email = 'chautm2@ncb-bank.vn';
            $business->category_business_id = 1; // danh mục business
            $business->business_license = null;  // giấy phép kinh doanh (file pdf nếu có)
            $business->social_channel = "https://www.ncb-bank.vn/";
            $business->description = "Ngân hàng TMCP Quốc Dân (NCB) được thành lập từ năm 1995, dưới tên gọi Ngân hàng Sông
Kiên. Sau đó, từ một ngân hàng nông thôn, NCB đã chuyển đổi quy mô thành ngân hàng đô thị,
đổi tên thành Ngân hàng TMCP Nam Việt– Navibank. Đến năm 2014, NCB chính thức được đổi
tên thành Ngân Hàng TMCP Quốc Dân – NCB. Trải qua 29 năm hoạt động, NCB đã từng bước
khẳng định được vị thế thương hiệu trên thị trường tài chính – tiền tệ Việt Nam.";
            $business->avt_businesses = "images/business/logo_ncb.jpg";
            $business->status = 'approved'; //('pending', 'approved', 'rejected')
            $business->created_at = now();
            $business->updated_at = now();

            $business->save();

            $user = $business->user()->create([
                'username' => '1700169765',
                'full_name' => 'NGÂN HÀNG TMCP QUỐC DÂN( NCB) - CN CỘNG HÒA',
                'avatar' => 'images/business/logo_ncb.jpg',
                'email' => 'chautm2@ncb-bank.vn',
                'password' => Hash::make('1700169765'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            //---------------------------------

            $business = new Business();
            $business->business_code = '0310151601';
            $business->business_name = 'CÔNG TY CỔ PHẦN SẮT MỸ THUẬT KHANG HƯNG PHÁT';
            $business->representative_name = 'TRỊNH HỮU PHƯỚC '; //người đại diện
            $business->birth_year = '1998'; //năm sinh người đại diện
            $business->gender = 'male'; //('male', 'female', 'other')
            $business->address = '93 Tô Ngọc Vân, Phường Thạnh Xuân, Quận 12, Thành phố Hồ Chí Minh, Việt Nam'; //(địa chỉ người đại diện)
            $business->phone_number = '0936679037';
            $business->fax_number = '';
            $business->business_address = '93 Tô Ngọc Vân, Phường Thạnh Xuân, Quận 12, Thành phố Hồ Chí Minh, Việt Nam';
            $business->ward_id = 3; //phường
            $business->email = 'kinhdoanh.khp@gmail.com';
            $business->category_business_id = 1; // danh mục business
            $business->business_license = null;  // giấy phép kinh doanh (file pdf nếu có)
            $business->social_channel = "https://khp.com.vn/";
            $business->description = "Khang Hưng Phát xác định chiến lược trọng tâm doanh nghiệp là tiếp tục nghiên cứu phát triển các dòng sản phẩm mới với chất lượng cao hơn nữa, phù hợp với mọi tiêu chuẩn Khách hàng. Đó là cam kết của Khang Hưng Phát với quý khách hàng. Sắt Mỹ Thuật KHP sẽ bằng mọi nỗ lực để tiếp tục là một thương hiệu uy tín trong ngành. Là đối tác tin cậy của Quý Khách trên toàn quốc.";
            $business->avt_businesses = "images/business/Logo-Cong-ty-Sat-My-Thuat-KHP.png";
            $business->status = 'approved'; //('pending', 'approved', 'rejected')
            $business->created_at = now();
            $business->updated_at = now();

            $business->save();

            $user = $business->user()->create([
                'username' => '0310151601',
                'full_name' => 'CÔNG TY CỔ PHẦN SẮT MỸ THUẬT KHANG HƯNG PHÁT',
                'avatar' => 'images/business/Logo-Cong-ty-Sat-My-Thuat-KHP.png',
                'email' => 'kinhdoanh.khp@gmail.com',
                'password' => Hash::make('0310151601'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            //-------------------


            $business = new Business();
            $business->business_code = '0312535057-001';
            $business->business_name = 'CHI NHÁNH CÔNG TY TNHH PHÁT TRIỂN P&K';
            $business->representative_name = 'NGUYỄN THỊ BÍCH VÂN'; //người đại diện
            $business->birth_year = '1998'; //năm sinh người đại diện
            $business->gender = 'female'; //('male', 'female', 'other')
            $business->address = 'Ấp Hoàng Việt, Xã Tân Phước, Huyện Tân Hồng, Tỉnh Đồng Tháp, Việt Nam'; //(địa chỉ người đại diện)
            $business->phone_number = '01642446216';
            $business->fax_number = '';
            $business->business_address = 'Ấp Hoàng Việt, Xã Tân Phước, Huyện Tân Hồng, Tỉnh Đồng Tháp, Việt Nam';
            $business->ward_id = 11; //phường
            $business->email = 'pk@gmail.com';
            $business->category_business_id = 1; // danh mục business
            $business->business_license = null;  // giấy phép kinh doanh (file pdf nếu có)
            $business->social_channel = "";
            $business->description = "Sản xuất thực phẩm khác chưa được phân vào đâu
Chi tiết: Sản xuất cà phê, trà";
            $business->avt_businesses = "images/business/logo_pk.jpg";
            $business->status = 'approved'; //('pending', 'approved', 'rejected')
            $business->created_at = now();
            $business->updated_at = now();

            $business->save();

            $user = $business->user()->create([
                'username' => '0312535057-001',
                'full_name' => 'CHI NHÁNH CÔNG TY TNHH PHÁT TRIỂN P&K',
                'avatar' => 'images/business/logo_pk.jpg',
                'email' => 'pk@gmail.com',
                'password' => Hash::make('0312535057-001'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productBusiness = $business->products()->create([
                'category_product_id' => 5,
                'name_product' => 'Trà bồ công anh',
                'slug' => 'tra-bo-cong-anh',
                'description' => null,
                'price' => 0,
                'product_story' => null,
                'product_avatar' => 'images/business-products/z5953244194849_ef9fbe35b40d1347b4d02dda76de9df3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productImage = ProductImage::create([
                'product_id' => $productBusiness->id,
                'image' => 'images/business-products/z5953244194849_ef9fbe35b40d1347b4d02dda76de9df3.jpg',
                'thumbnail' => 'images/business-products/z5953244194849_ef9fbe35b40d1347b4d02dda76de9df3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productImage = ProductImage::create([
                'product_id' => $productBusiness->id,
                'image' => 'images/business-products/z5953244206222_391982588dfb54da7609258a7ce86979.jpg',
                'thumbnail' => 'images/business-products/z5953244206222_391982588dfb54da7609258a7ce86979.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            //------

            $productBusiness = $business->products()->create([
                'category_product_id' => 5,
                'name_product' => 'Trà xuyên tâm liên',
                'slug' => 'tra-xuyen-tam-lien',
                'description' => null,
                'price' => 0,
                'product_story' => null,
                'product_avatar' => 'images/business-products/z5953244212052_d0d6959111f1d8118f2865d515d2cb9d.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productImage = ProductImage::create([
                'product_id' => $productBusiness->id,
                'image' => 'images/business-products/z5953244212052_d0d6959111f1d8118f2865d515d2cb9d.jpg',
                'thumbnail' => 'images/business-products/z5953244212052_d0d6959111f1d8118f2865d515d2cb9d.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productImage = ProductImage::create([
                'product_id' => $productBusiness->id,
                'image' => 'images/business-products/z5953244190645_994bcc6e9b34718577198eebe84cfac0.jpg',
                'thumbnail' => 'images/business-products/z5953244190645_994bcc6e9b34718577198eebe84cfac0.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            //------

            $productBusiness = $business->products()->create([
                'category_product_id' => 5,
                'name_product' => 'Trà TARAXA TEA',
                'slug' => 'tra-taraxa-tea',
                'description' => null,
                'price' => 0,
                'product_story' => null,
                'product_avatar' => 'images/business-products/z5953244232967_60649214f2e3c51fde3e08baa8cff2dc.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productImage = ProductImage::create([
                'product_id' => $productBusiness->id,
                'image' => 'images/business-products/z5953244232967_60649214f2e3c51fde3e08baa8cff2dc.jpg',
                'thumbnail' => 'images/business-products/z5953244232967_60649214f2e3c51fde3e08baa8cff2dc.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productImage = ProductImage::create([
                'product_id' => $productBusiness->id,
                'image' => 'images/business-products/z5953244226688_1692800cbd7b96d5ad09e5099d603163.jpg',
                'thumbnail' => 'images/business-products/z5953244226688_1692800cbd7b96d5ad09e5099d603163.jpg',
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
