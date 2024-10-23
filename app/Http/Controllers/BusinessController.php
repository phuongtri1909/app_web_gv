<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessCapitalNeed;
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
            'birth_year' => 'required|digits:4',
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
        return view('pages.client.gv.form-promotional-introduction');
    }

    public function businessOpinion()
    {
        return view('pages.client.form-business-opinion');
    }

}
