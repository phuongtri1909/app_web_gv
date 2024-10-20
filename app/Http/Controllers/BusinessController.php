<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\CategoryBusiness;
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
}
