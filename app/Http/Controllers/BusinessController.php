<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\CategoryBusiness;
use App\Models\WardGovap;
use Illuminate\Http\Request;

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
           'business_code' => 'required|string|max:255|unique:businesses,business_code',
           'business_name' => 'required|string|max:255',
           'representative_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:10|regex:/^[0-9]+$/',
            'fax_number' => 'nullable|string|max:15',
            'address' => 'required|string|max:255',
            'ward_id' => 'required|integer',
            'email' => 'required|email|max:255|unique:businesses,email',
            'category_business_id' => 'required|integer',
            'business_license' => 'nullable|file|mimes:pdf|max:2048',
            'social_channel' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'avt_businesses' => 'nullable|file|mimes:jpg,jpeg,png|max:5048',
        ],[
            'business_code.unique' => 'Mã doanh nghiệp này đã tồn tại.',
            'business_code.required' => 'Mã doanh nghiệp là bắt buộc.',
            'business_name.required' => 'Tên doanh nghiệp là bắt buộc.',
            'representative_name.required' => 'Tên người đại diện pháp luật là bắt buộc.',
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
            'business_license.max' => 'Giấy phép kinh doanh không được vượt quá 2MB.',
            'social_channel.url' => 'Đường dẫn social không hợp lệ.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'avt_businesses.mimes' => 'Hình ảnh đại diện phải là file dạng: jpg, jpeg, png.',
            'avt_businesses.max' => 'Hình ảnh đại diện không được vượt quá 5MB.',
        ]);

        $data = $request->all();

        if ($request->hasFile('avt_businesses')) {
            $file = $request->file('avt_businesses');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data['avt_businesses'] = $filename;
        }

        if ($request->hasFile('business_license')) {
            $file = $request->file('business_license');
            $licenseName = time() . '_license.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $licenseName);
            $data['business_license'] = $licenseName;
        }
        // dd($data);
        Business::create($data);

        return redirect()->route('business.index')->with('success', 'Gửi thành công!!');
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

    public function business()
    {
        $businesses = Business::all();
        return view('pages.client.business', compact('businesses'));
    }

    public function businessDetail($id)
    {
        
        return view('pages.client.detail-business');
    }
}
