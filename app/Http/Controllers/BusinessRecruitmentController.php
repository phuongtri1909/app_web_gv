<?php

namespace App\Http\Controllers;

use App\Models\BusinessRecruitment;
use App\Models\CategoryBusiness;
use Illuminate\Http\Request;

class BusinessRecruitmentController extends Controller
{
    //
    public function index()
    {
        $businessRecruitments = BusinessRecruitment::with('categoryBusiness')->get();
        return view('admin.pages.client.form-recruitment.index', compact('businessRecruitments'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

public function show($id)
{
    $businessRecruitment = BusinessRecruitment::with('categoryBusiness')->findOrFail($id);
    return response()->json([
        'business_name' => $businessRecruitment->business_name,
        'business_code' => $businessRecruitment->business_code,
        'category_business' => $businessRecruitment->categoryBusiness,
        'head_office_address' => $businessRecruitment->head_office_address,
        'phone' => $businessRecruitment->phone,
        'fax' => $businessRecruitment->fax,
        'email' => $businessRecruitment->email,
        'representative_name' => $businessRecruitment->representative_name,
        'gender' => $businessRecruitment->gender,
        'recruitment_info' => $businessRecruitment->recruitment_info,
        'status' => $businessRecruitment->status,
    ]);
}

    public function edit(BusinessRecruitment $businessRecruitment)
    {
       
    }

    public function update(Request $request, BusinessRecruitment $businessRecruitment)
    {
       
    }

    public function destroy(BusinessRecruitment $businessRecruitment)
    {
        $businessRecruitment->delete();
        return redirect()->route('business-recruitments.index')->with('success', 'Recruitment deleted successfully');
    }

    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_code' => 'required|regex:/^\d{10}(-\d{3})?$/',
            'category_business_id' => 'required|exists:category_business,id',
            'head_office_address' => 'required|string|max:255',
            'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
            'fax' => 'nullable|string|regex:/^(\+?\d{1,3})?[-.\s]?\(?\d{1,4}\)?[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/',
            'email' => 'nullable|email|max:255',
            'representative_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'recruitment_info' => 'required|string|max:2000',
        ], [
            'business_name.required' => 'Tên doanh nghiệp là bắt buộc.',
            'business_code.required' => 'Mã số doanh nghiệp/Mã số thuế là bắt buộc.',
            'business_code.regex' => 'Mã số thuế phải gồm 10 chữ số hoặc 13 chữ số với định dạng 10-3.',
            'category_business_id.required' => 'Loại hình doanh nghiệp là bắt buộc.',
            'category_business_id.exists' => 'Loại hình doanh nghiệp không hợp lệ.',
            'head_office_address.required' => 'Địa chỉ trụ sở chính là bắt buộc.',
            'head_office_address.max' => 'Địa chỉ trụ sở chính không được hơn 255 ký tự.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.max' => 'Số điện thoại phải có 10 số.',
            'fax.regex' => 'Số điện thoại không hợp lệ.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được hơn 255 ký tự.',
            'representative_name.required' => 'Tên người đại diện pháp luật là bắt buộc.',
            'representative_name.max' => 'Tên người đại diện pháp luật không được hơn 255 ký tự.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'recruitment_info.required' => 'Thông tin đăng ký tuyển dụng nhân sự là bắt buộc.',
            'recruitment_info.max' => 'Thông tin đăng ký tuyển dụng nhân sự không được hơn 2000 ký tự.',
            'business_name.max' => 'Tên doanh nghiệp không được hơn 255 ký tự.',
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
