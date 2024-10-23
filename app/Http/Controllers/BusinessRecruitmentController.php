<?php

namespace App\Http\Controllers;

use App\Models\BusinessRecruitment;
use App\Models\CategoryBusiness;
use Illuminate\Http\Request;

class BusinessRecruitmentController extends Controller
{
    //
    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_code' => 'required|string|max:255',
            'category_business_id' => 'required|exists:category_business,id',
            'head_office_address' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'fax' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'representative_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'recruitment_info' => 'required|string',
        ], [
            'business_name.required' => 'Tên doanh nghiệp là bắt buộc.',
            'business_code.required' => 'Mã số doanh nghiệp/Mã số thuế là bắt buộc.',
            'category_business_id.required' => 'Loại hình doanh nghiệp là bắt buộc.',
            'head_office_address.required' => 'Địa chỉ trụ sở chính là bắt buộc.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.digits' => 'Số điện thoại phải có 10 chữ số.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'representative_name.required' => 'Tên người đại diện pháp luật là bắt buộc.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'recruitment_info.required' => 'Thông tin đăng ký tuyển dụng nhân sự là bắt buộc.',
        ]);

        BusinessRecruitment::create([
            'business_name' => $validated['business_name'],
            'business_code' => $validated['business_code'],
            'category_business_id' => $validated['category_business_id'],
            'head_office_address' => $validated['head_office_address'],
            'phone' => $validated['phone'],
            'fax' => $validated['fax'],
            'email' => $validated['email'],
            'representative_name' => $validated['representative_name'],
            'gender' => $validated['gender'],
            'recruitment_info' => $validated['recruitment_info'],
        ]);

        return redirect()->back()->with('success', 'Đăng ký tuyển dụng thành công!');
    }

    public function recruitmentRegistration()
    {
        $category_business = CategoryBusiness::all();
        return view('pages.client.form-recruitment-registration', compact('category_business'));
    }
}
