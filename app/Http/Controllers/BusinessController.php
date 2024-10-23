<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessCapitalNeed;
use App\Models\BusinessFeedback;
use App\Models\BusinessField;
use App\Models\BusinessPromotionalIntroduction;
use App\Models\BusinessStartPromotionInvestment;
use App\Models\BusinessSupportNeed;
use App\Models\CategoryBusiness;
use App\Models\CategoryProductBusiness;
use App\Models\ProductBusiness;
use App\Models\WardGovap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessController extends Controller
{

    public function index()
    {
        $wards = WardGovap::all();
        $category_business = CategoryBusiness::all();
        $businesses = Business::all();
        return view('pages.client.form-business', compact('businesses','wards','category_business'));
    }


    public function create()
    {
        return view('pages.client.form-business');
    }

    public function store(Request $request)
    {

        $request->validate([
            'avt_businesses' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'representative_name' => 'required|string|max:255',
            'birth_year' => 'required|digits:4|min:1500|max:' . date('Y'),
            'gender' => 'required|string',
            'phone_number' => 'required|string|max:10|regex:/^[0-9]+$/',
            'address' => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'ward_id' => 'required|integer|exists:ward_govap,id',
            'business_name' => 'required|string|max:255',
            'business_license' => 'nullable|mimes:pdf|max:3048',
            'business_code' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'social_channel' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'business_code.unique' => 'Mã doanh nghiệp này đã tồn tại.',
            'business_code.required' => 'Mã doanh nghiệp là bắt buộc.',
            'business_name.required' => 'Tên doanh nghiệp là bắt buộc.',
            'representative_name.required' => 'Tên người đại diện pháp luật là bắt buộc.',
            'birth_year.required' => 'Năm sinh là bắt buộc.',
            'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
            'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
            'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.regex' => 'Số điện thoại chỉ chứa số.',
            'phone_number.max' => 'Số điện thoại không được hơn 10 số.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'ward_id.required' => 'Vui lòng chọn phường.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'category_business_id.required' => 'Vui lòng chọn loại hình doanh nghiệp.',
            'business_license.mimes' => 'Giấy phép kinh doanh phải là file dạng: pdf',
            'business_license.max' => 'Giấy phép kinh doanh không được vượt quá 3MB.',
            'social_channel.url' => 'Đường dẫn social không hợp lệ.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'avt_businesses.mimes' => 'Hình ảnh đại diện phải là file dạng: jpg, jpeg, png.',
            'avt_businesses.max' => 'Hình ảnh đại diện không được vượt quá 5MB.',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->except(['business_license', 'avt_businesses']);


            if ($request->hasFile('avt_businesses')) {
                $image = $request->file('avt_businesses');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/business/' . $folderName), $fileName);
                $data['avt_businesses'] = 'uploads/images/business/' . $folderName . '/' . $fileName;
            }


            if ($request->hasFile('business_license')) {
                $file = $request->file('business_license');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $licenseName = $originalFileName . '_license_' . time() . '.' . $extension;
                $file->move(public_path('/uploads/images/business/' . $folderName), $licenseName);
                $data['business_license'] = 'uploads/images/business/' . $folderName . '/' . $licenseName;
            }

            Business::create($data);

            DB::commit();

            return redirect()->route('business.index')->with('success', 'Gửi thành công!!');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($filename) && file_exists(public_path( $data['business_license']))) {
                unlink(public_path( $data['business_license']));
            }

            if (isset($licenseName) && file_exists(public_path( $data['avt_businesses']))) {
                unlink(public_path( $data['avt_businesses']));
            }

            return redirect()->back()->with('error', 'Gửi thất bại: ' . $e->getMessage());
        }
    }




    public function show($id)
    {
        $business = Business::findOrFail($id);
        return view('business.show', compact('business'));
    }


    public function edit($id)
    {
        $business = Business::findOrFail($id);
        return view('business.edit', compact('business'));
    }

       public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $business = Business::findOrFail($id);
        $business->update($request->all());

        return redirect()->route('business.index')->with('success', 'Business updated successfully.');
    }


    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();

        return redirect()->route('business.index')->with('success', 'Business deleted successfully.');
    }

    public function business(Request $request)
    {
        $category = $request->category ?? '';


    //deploy xong fix status
        if ($category) {
            $category_product_business = CategoryProductBusiness::where('slug', $category)->first();

            $businesses = Business::whereHas('products', function ($query) use ($category_product_business) {
                $query->where('category_product_id', $category_product_business->id);
            })->get();
        } else {
            $businesses = Business::get();
        }
        $category_product_business = CategoryProductBusiness::get();

        return view('pages.client.business', compact('businesses', 'category_product_business'));
    }

    public function businessDetail($business_code)
    {
        $business = Business::where('business_code', $business_code)->first();

        if (!$business) {
            return redirect()->route('business')->with('error', 'Không tìm thấy doanh nghiệp');
        }

        return view('pages.client.detail-business', compact('business'));
    }

    public function productDetail($slug)
    {
        $product = ProductBusiness::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->route('business')->with('error', 'Không tìm thấy sản phẩm');
        }

        return view('pages.client.detail-product-business', compact('product'));
    }

    public function businessProducts(Request $request){
        $category = $request->category ?? '';
        if ($category) {
            $category_product_business = CategoryProductBusiness::where('slug', $category)->first();

            $products = ProductBusiness::where('category_product_id', $category_product_business->id)->get();
        } else {
            $products = ProductBusiness::get();
        }

        $category_product_business = CategoryProductBusiness::get();

        return view('pages.client.business-products', compact('products', 'category_product_business'));
    }

    public function connectSupplyDemand()
    {
        return view('pages.client.form-connect-supply-demand');
    }


    public function showFormStartPromotion(){
        $business_support_needs = BusinessSupportNeed::all();
        return view('pages.client.gv.start-promotion-investment',compact('business_support_needs'));
    }
    public function storeFormStartPromotion(Request $request)
    {
        $validatedData = $request->validate([
            'representative_name' => 'required|string|max:255',
            'birth_year' => 'required|digits:4|min:1500|max:' . date('Y'),
            'gender' => 'required|in:male,female,other',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'business_field' => 'required|string|max:255',
            'business_code' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'fanpage' => 'nullable|url|max:255',
            'support_need' => 'required|exists:business_support_needs,id',
        ], [
            'representative_name.required' => 'Họ tên là bắt buộc.',
            'representative_name.string' => 'Họ tên phải là chuỗi ký tự.',
            'representative_name.max' => 'Họ tên không được vượt quá :max ký tự.',

            'birth_year.required' => 'Năm sinh là bắt buộc.',
            'birth_year.integer' => 'Năm sinh phải là một số nguyên.',
            'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
            'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
            'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'gender.in' => 'Giới tính không hợp lệ.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá :max ký tự.',

            'address.required' => 'Địa chỉ cư trú là bắt buộc.',
            'address.string' => 'Địa chỉ cư trú phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ cư trú không được vượt quá :max ký tự.',

            'business_address.required' => 'Địa chỉ kinh doanh là bắt buộc.',
            'business_address.string' => 'Địa chỉ kinh doanh phải là chuỗi ký tự.',
            'business_address.max' => 'Địa chỉ kinh doanh không được vượt quá :max ký tự.',

            'business_name.required' => 'Tên doanh nghiệp/hộ kinh doanh là bắt buộc.',
            'business_name.string' => 'Tên doanh nghiệp/hộ kinh doanh phải là chuỗi ký tự.',
            'business_name.max' => 'Tên doanh nghiệp/hộ kinh doanh không được vượt quá :max ký tự.',

            'business_field.required' => 'Ngành nghề kinh doanh là bắt buộc.',
            'business_field.string' => 'Ngành nghề kinh doanh phải là chuỗi ký tự.',
            'business_field.max' => 'Ngành nghề kinh doanh không được vượt quá :max ký tự.',

            'business_code.required' => 'Mã số thuế là bắt buộc.',
            'business_code.string' => 'Mã số thuế phải là chuỗi ký tự.',
            'business_code.max' => 'Mã số thuế không được vượt quá :max ký tự.',

            'email.required' => 'Email doanh nghiệp là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá :max ký tự.',

            'fanpage.url' => 'Link fanpage không hợp lệ.',
            'fanpage.max' => 'Link fanpage không được vượt quá :max ký tự.',

            'support_need.required' => 'Nhu cầu hỗ trợ là bắt buộc.',
            'support_need.exists' => 'Nhu cầu hỗ trợ không hợp lệ.',
        ]);



        BusinessStartPromotionInvestment::create([
            'representative_name' => $validatedData['representative_name'],
            'birth_year' => $validatedData['birth_year'],
            'gender' => $validatedData['gender'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'business_address' => $validatedData['business_address'],
            'business_name' => $validatedData['business_name'],
            'business_code' => $validatedData['business_code'],
            'business_field' => $validatedData['business_field'],
            'email' => $validatedData['email'],
            'fanpage' => $validatedData['fanpage'],
            'business_support_needs_id' => $validatedData['support_need'],
        ]);
        return redirect()->back()->with('success', 'Đăng ký thành công!');
    }


    public function showFormCapitalNeeds(){

        $category_business = CategoryBusiness::all();
        return view('pages.client.gv.registering-capital-needs',compact('category_business'));
    }
    public function storeFormCapitalNeeds(Request $request)
    {
        $validatedData = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_code' => 'required|string|max:255',
            'category_business_id' => 'required|exists:category_business,id',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
            'fax' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'representative_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'interest_rate' => 'required|numeric',
            'finance' => 'required|numeric',
            'mortgage_policy' => 'required|string|max:1000',
            'unsecured_policy' => 'required|string|max:1000',
            'purpose' => 'required|string|max:1000',
            'bank_connection' => 'required|string',
            'feedback' => 'nullable|string|max:1000',
        ], [
            'business_name.required' => 'Vui lòng nhập tên doanh nghiệp.',
            'business_code.required' => 'Mã số doanh nghiệp là bắt buộc.',
            'category_business_id.required' => 'Vui lòng chọn loại hình kinh doanh.',
            'category_business_id.exists' => 'Loại hình kinh doanh không hợp lệ.',
            'address.required' => 'Địa chỉ doanh nghiệp là bắt buộc.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.max' => 'Số điện thoại không được vượt quá 10 chữ số.',
            'phone.regex' => 'Số điện thoại chỉ được phép chứa các ký tự số.',
            'email.required' => 'Vui lòng nhập email hợp lệ.',
            'email.email' => 'Định dạng email không đúng.',
            'representative_name.required' => 'Vui lòng nhập tên người đại diện.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'interest_rate.numeric' => 'Lãi suất phải là một số hợp lệ.',
            'finance.numeric' => 'Số tiền tài chính phải là một số hợp lệ.',
            'feedback.max' => 'Phản hồi không được vượt quá 1000 ký tự.',
            'purpose.required' => 'Vui lòng nhập mục đích của bạn.',
            'bank_connection.required' => 'Vui lòng nhập thông tin kết nối ngân hàng.',
            'mortgage_policy.required' => 'Vui lòng cung cấp chính sách thế chấp.',
            'unsecured_policy.required' => 'Vui lòng cung cấp chính sách tín chấp.',
            'unsecured_policy.max' => 'Tín chấp không được vượt quá 1000 ký tự.',
            'mortgage_policy.max' => 'Thế chấp không được vượt quá 1000 ký tự.',
            'purpose.max' => 'Mục đích không được vượt quá 1000 ký tự.',
        ]);
        BusinessCapitalNeed::create($validatedData);


        return redirect()->back()->with('success', 'Đăng ký thành công!');
    }
    public function showFormPromotional(){
        $business_fields = BusinessField::all();
        return view('pages.client.gv.form-promotional-introduction',compact('business_fields'));
    }
    public function storeFormPromotional(Request $request)
    {
        DB::beginTransaction();
        $data = [];

        try {
            $request->validate([
                'representative_name' => 'required|string|max:255',
                'birth_year' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
                'gender' => 'required|in:male,female,other',
                'phone_number' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'business_address' => 'required|string|max:255',
                'business_name' => 'required|string|max:255',
                'license' => 'required|file|mimes:pdf|max:4048',
                'business_code' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'social_channel' => 'nullable|url',
                'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
                'product_image.*' => 'image|mimes:jpg,png,jpeg,gif|max:2048',
                'product_video' => 'nullable|file|mimes:mp4,mov,avi|max:20480',
                'business_field' => 'required|string',
            ], [
                'representative_name.required' => 'Vui lòng nhập họ tên chủ doanh nghiệp.',
                'birth_year.required' => 'Năm sinh là bắt buộc.',
                'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
                'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
                'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
                'gender.required' => 'Vui lòng chọn giới tính.',
                'phone_number.required' => 'Vui lòng nhập số điện thoại.',
                'address.required' => 'Vui lòng nhập địa chỉ cư trú.',
                'business_address.required' => 'Vui lòng nhập địa chỉ kinh doanh.',
                'business_name.required' => 'Vui lòng nhập tên doanh nghiệp/hộ kinh doanh.',
                'business_code.required' => 'Vui lòng nhập mã số thuế.',
                'email.required' => 'Vui lòng nhập email doanh nghiệp.',
                'email.email' => 'Email không hợp lệ.',
                'social_channel.url' => 'Đường dẫn fanpage không hợp lệ.',
                'logo.image' => 'Logo phải là một hình ảnh.',
                'logo.mimes' => 'Logo phải có định dạng jpg, png, jpeg, hoặc gif.',
                'logo.max' => 'Logo không được vượt quá 2MB.',
                'product_image.image' => 'Hình ảnh sản phẩm phải là một hình ảnh.',
                'product_image.mimes' => 'Hình ảnh sản phẩm phải có định dạng jpg, png, jpeg, hoặc gif.',
                'product_image.max' => 'Hình ảnh sản phẩm không được vượt quá 2MB.',
                'product_video.file' => 'Video phải là một tệp.',
                'product_video.mimes' => 'Video phải có định dạng mp4, mov, hoặc avi.',
                'product_video.max' => 'Video không được vượt quá 20MB.',
                'business_field.required' => 'Vui lòng chọn ngành nghề kinh doanh.',
                'license.required' => 'Vui lòng tải lên giấy phép kinh doanh.',
                'license.file' => 'Giấy phép kinh doanh phải là một tệp.',
                'license.mimes' => 'Giấy phép kinh doanh phải có định dạng pdf.',
                'license.max' => 'Giấy phép kinh doanh không được vượt quá 4MB.',
            ]);

            $business = new BusinessPromotionalIntroduction();
            $business->fill($request->only([
                'representative_name', 'birth_year', 'gender', 'phone_number',
                'address', 'business_address', 'business_name',
                'business_code', 'email', 'social_channel'
            ]));
            $this->handleFileUpload($request, 'logo', $data, '_logo_','business');
            $this->handleFileUpload($request, 'product_image', $data, '_product_','business');
            $this->handleFileUpload($request, 'product_video', $data, '_video_','business');
            $this->handleFileUpload($request, 'license', $data, '_license_','business');

            $business->logo = $data['logo'];
            $business->product_image = $data['product_image'];
            $business->product_video = $data['product_video'];
            $business->license = $data['license'];
            $business->save();

            if ($request->business_field) {
                $businessField = BusinessField::where('name', $request->business_field)->first();
                if ($businessField) {
                    $business->businessField()->attach($businessField->id);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Đăng ký thành công!');

        } catch (\Exception $e) {
            DB::rollBack();

            $this->cleanupUploadedFiles($data);

            return redirect()->back()->with('error', 'Gửi thất bại: ' . $e->getMessage());
        }
    }

    public function businessOpinion()
    {
        return view('pages.client.form-business-opinion');
    }
    public function storeBusinessOpinion(Request $request)
    {
        DB::beginTransaction();
        $data = [];

        try {
            $request->validate([
                'opinion' => 'required|string',
                'attached_images.*' => 'required|image|mimes:jpg,png,jpeg,gif|max:9048',
                'suggestions' => 'nullable|string',
                'owner_full_name' => 'required|string|max:255',
                'birth_year' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
                'gender' => 'required|in:male,female,other',
                'phone' => 'required|string|max:15',
                'residential_address' => 'required|string|max:255',
                'business_name' => 'required|string|max:255',
                'business_address' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'business_license' => 'required|file|mimes:pdf|max:4048',
            ], [
                'opinion.required' => 'Vui lòng nhập ý kiến.',
                'attached_images.required' => 'Vui lòng tải lên ít nhất một hình ảnh.',
                'attached_images.image' => 'Tệp phải là một hình ảnh.',
                'attached_images.mimes' => 'Hình ảnh phải có định dạng jpg, png, jpeg, hoặc gif.',
                'attached_images.max' => 'Hình ảnh không được vượt quá 9MB.',
                'owner_full_name.required' => 'Vui lòng nhập họ tên chủ doanh nghiệp.',
                'birth_year.required' => 'Năm sinh là bắt buộc.',
                'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
                'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
                'gender.required' => 'Vui lòng chọn giới tính.',
                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'residential_address.required' => 'Vui lòng nhập địa chỉ cư trú.',
                'business_name.required' => 'Vui lòng nhập tên doanh nghiệp/hộ kinh doanh.',
                'business_address.required' => 'Vui lòng nhập địa chỉ kinh doanh.',
                'email.required' => 'Vui lòng nhập email.',
                'email.email' => 'Email không hợp lệ.',
                'business_license.mimes' => 'Giấy phép kinh doanh phải là file dạng: pdf',
                'business_license.max' => 'Giấy phép kinh doanh không được vượt quá 3MB.',
            ]);
            $businessOpinion = new BusinessFeedback();
            $businessOpinion->fill($request->only([
                'opinion', 'suggestions', 'owner_full_name', 'birth_year', 'gender', 'phone',
                'residential_address', 'business_name', 'business_address', 'email'
            ]));
            $this->handleFileUpload($request, 'attached_images', $data, '_attached_images_', 'feedback');
            $this->handleFileUpload($request, 'business_license', $data, '_business_license_', 'business');
            $businessOpinion->attached_images = $data['attached_images'];
            $businessOpinion->business_license = $data['business_license'];
            $businessOpinion->save();

            DB::commit();
            return redirect()->back()->with('success', 'Đăng ký thành công!');

        } catch (\Exception $e) {
            DB::rollBack();

            $this->cleanupUploadedFiles($data);

            return redirect()->back()->with('error', 'Gửi thất bại: ' . $e->getMessage());
        }
    }



    private function handleFileUpload(Request $request, $inputName, &$data, $suffix = '', $folderType = 'business')
    {
        if ($request->hasFile($inputName)) {
            $files = is_array($request->file($inputName)) ? $request->file($inputName) : [$request->file($inputName)];
            $uploadedFiles = [];
            $folderName = date('Y/m');

            foreach ($files as $file) {
                if ($file->isValid()) {
                    $filePath = $this->moveFile($file, $folderName, $suffix, $folderType);
                    $uploadedFiles[] = $filePath;
                }
            }
            if (!empty($uploadedFiles)) {
                $data[$inputName] = json_encode($uploadedFiles);
            }
        }
    }

    private function moveFile($file, $folderName, $suffix, $folderType)
    {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $originalFileName . $suffix . time() . '.' . $extension;

        $basePath = '';
        switch ($folderType) {
            case 'feedback':
                $basePath = 'uploads/images/feedback/';
                break;
            case 'business':
                $basePath = 'uploads/images/business/';
                break;
            case 'other':
                $basePath = 'uploads/images/other/';
                break;
            default:
                throw new \Exception('Thư mục không hợp lệ.');
        }

        $file->move(public_path($basePath . $folderName), $fileName);
        return $basePath . $folderName . '/' . $fileName;
    }



    private function cleanupUploadedFiles(array $data)
    {
        foreach ($data as $filePath) {
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
        }
    }

}
