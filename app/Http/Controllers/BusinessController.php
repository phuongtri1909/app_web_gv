<?php

namespace App\Http\Controllers;

use App\Models\Business;
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
            'description' => 'nullable|string',
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

            if (isset($filename) && file_exists(public_path('uploads/' . $filename))) {
                unlink(public_path('uploads/' . $filename));
            }

            if (isset($licenseName) && file_exists(public_path('uploads/' . $licenseName))) {
                unlink(public_path('uploads/' . $licenseName));
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
        return view('pages.client.gv.start-promotion-investment');
    }

    public function showFormCapitalNeeds(){
        return view('pages.client.gv.registering-capital-needs');
    }
    public function showFormPromotional(){
        return view('pages.client.gv.form-promotional-introduction');
    }

    public function businessOpinion()
    {
        return view('pages.client.form-business-opinion');
    }

}
