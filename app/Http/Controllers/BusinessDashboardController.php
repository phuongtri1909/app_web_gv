<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessField;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BusinessDashboardController extends Controller
{
    public function index()
    {
        $business_member = auth()->user()->businessMember;

        $businessFieldIds = json_decode($business_member->business_field_id, true);

        $business_fields = BusinessField::get();

        $businessFields = $business_fields->filter(function ($business_field) use ($businessFieldIds) {
            return in_array($business_field->id, $businessFieldIds);
        });

        return view('admin.business.dashboard', compact('business_member', 'businessFields', 'business_fields'));
    }

    public function updateBusiness(Request $request)
    {
        try {
            $business_member = auth()->user()->businessMember;

            $request->validate([
                'business_name' => 'required|string|max:255'
            ], [
                'business_name.required' => 'Tên doanh nghiệp không được để trống',
                'business_name.string' => 'Tên doanh nghiệp phải là chuỗi',
                'business_name.max' => 'Tên doanh nghiệp không được vượt quá 255 ký tự'
            ]);

            $business_member->update([
                'business_name' => $request->business_name,
            ]);

            if ($business_member->business && $business_member->business->status == "approved") {
                if ($request->hasFile('avt_businesses')) {
                    $request->validate([
                        'avt_businesses' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
                    ], [
                        'avt_businesses.required' => 'Ảnh đại diện không được để trống',
                        'avt_businesses.image' => 'Ảnh đại diện phải là ảnh',
                        'avt_businesses.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif, svg',
                    ]);

                    $image = $request->file('avt_businesses');

                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = $originalFileName . '_' . time() . '.webp';
                    $uploadPath = public_path('uploads/images/avatar/' . $folderName);

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                    $img = Image::make($image->getRealPath());
                    $img->resize(200, 200)->encode('webp', 75);
                    $img->save($uploadPath . '/' . $fileName);

                    $imgPath = 'uploads/images/avatar/' . $folderName . '/' . $fileName;
                }

                $business_member->business->update([
                    'avt_businesses' => $imgPath ?? $business_member->business->avt_businesses,
                    'description' => $request->description,
                ]);
            }

            return redirect()->back()->with('success', 'Cập nhật thông tin doanh nghiệp thành công');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('modal', 'editModal');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật thông tin doanh nghiệp thất bại')->with('modal', 'editModal');
        }
    }

    public function updateBusinessMember(Request $request)
    {

        try {

            $business_member = auth()->user()->businessMember;

            $request->validate([
                'address' => 'required|string|max:255',
                'phone_zalo' => 'required|string|max:10|regex:/^[0-9]+$/',
                'email' => 'nullable|email|max:255',
                'link' => 'nullable|url|max:255',
                'business_field_id' => 'nullable|array',
                'business_field_id.*' => 'nullable|exists:business_fields,id',
            ], [
                'address.required' => 'Vui lòng nhập địa chỉ',
                'address.string' => 'Địa chỉ phải là chuỗi',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
                'phone_zalo.required' => 'Vui lòng nhập số điện thoại zalo',
                'phone_zalo.string' => 'Số điện thoại zalo phải là chuỗi',
                'phone_zalo.max' => 'Số điện thoại zalo không được vượt quá 10 ký tự',
                'phone_zalo.regex' => 'Số điện thoại zalo không hợp lệ',
                'email.email' => 'Email không hợp lệ',
                'email.max' => 'Email không được vượt quá 255 ký tự',
                'link.url' => 'Link không hợp lệ',
                'link.max' => 'Link không được vượt quá 255 ký tự',
                'business_field_id.array' => 'Dữ liệu ngành nghề không hợp lệ',
                'business_field_id.*.exists' => 'Ngành nghề :input không tồn tại',
            ]);

            $business_member->update([
                'address' => $request->address,
                'phone_zalo' => $request->phone_zalo,
                'email' => $request->email,
                'link' => $request->link,
                'business_field_id' => json_encode($request->input('business_field_id')),
            ]);

            return redirect()->back()->with('success', 'Cập nhật thông tin doanh nghiệp thành công');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('modal', 'editBusinessInfoModal');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật thông tin doanh nghiệp thất bại')->with('modal', 'editBusinessInfoModal');
        }
    }

    public function updateRepresentativeInfo(Request $request) {

        try{
            $request->validate([
                'representative_full_name' => 'required|string|max:255',
                'representative_phone' => 'required|string|max:10|regex:/^[0-9]+$/',

            ],[
                'representative_full_name.required' => 'Vui lòng nhập họ tên người đại diện',
                'representative_full_name.string' => 'Họ tên người đại diện phải là chuỗi',
                'representative_full_name.max' => 'Họ tên người đại diện không được vượt quá 255 ký tự',
                'representative_phone.required' => 'Vui lòng nhập số điện thoại người đại diện',
                'representative_phone.string' => 'Số điện thoại người đại diện phải là chuỗi',
                'representative_phone.max' => 'Số điện thoại người đại diện không được vượt quá 10 ký tự',
                'representative_phone.regex' => 'Số điện thoại người đại diện không hợp lệ',
            ]);

            $business_member = auth()->user()->businessMember;

            $business_member->update([
                'representative_full_name' => $request->representative_full_name,
                'representative_phone' => $request->representative_phone,
            ]);

            return redirect()->back()->with('success', 'Cập nhật thông tin người đại diện thành công');
        }catch(\Illuminate\Validation\ValidationException $e){
            return redirect()->back()->withErrors($e->errors())->withInput()->with('modal', 'editRepresentativeInfoModal');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Cập nhật thông tin người đại diện thất bại')->with('modal', 'editRepresentativeInfoModal');
        }

    }

    public function updateAccountInfo(Request $request)
    {
        try {
            $user = auth()->user();

            $rules = [
                'full_name' => 'required|string|max:255',
            ];

            $messages = [
                'full_name.required' => 'Vui lòng nhập họ tên',
                'full_name.string' => 'Họ tên phải là chuỗi',
                'full_name.max' => 'Họ tên không được vượt quá 255 ký tự',
            ];

            if ($request->filled('password') || $request->filled('password_confirmation') || $request->filled('old_password')) {
                $rules['old_password'] = 'required|string';
                $rules['password'] = 'required|string|min:8|confirmed';
                $rules['password_confirmation'] = 'required|string|min:8';

                $messages['old_password.required'] = 'Vui lòng nhập mật khẩu cũ';
                $messages['old_password.string'] = 'Mật khẩu cũ phải là chuỗi';
                $messages['password.required'] = 'Vui lòng nhập mật khẩu mới';
                $messages['password.string'] = 'Mật khẩu phải là chuỗi';
                $messages['password.min'] = 'Mật khẩu phải có ít nhất 8 ký tự';
                $messages['password.confirmed'] = 'Mật khẩu không khớp';
                $messages['password_confirmation.required'] = 'Vui lòng nhập lại mật khẩu mới';
                $messages['password_confirmation.string'] = 'Mật khẩu xác nhận phải là chuỗi';
                $messages['password_confirmation.min'] = 'Mật khẩu xác nhận phải có ít nhất 8 ký tự';
            }

            $request->validate($rules, $messages);

            if ($request->filled('password') && !\Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->withErrors(['old_password' => 'Mật khẩu cũ không chính xác'])->withInput()->with('modal', 'editAccountInfoModal');
            }

            $user->update([
                'full_name' => $request->full_name,
                'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
            ]);

            return redirect()->back()->with('success', 'Cập nhật thông tin tài khoản thành công');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('modal', 'editAccountInfoModal');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật thông tin tài khoản thất bại')->with('modal', 'editAccountInfoModal');
        }
    }
}
