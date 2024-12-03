<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BusinessField;
use App\Models\BusinessMember;
use App\Mail\BusinessRegistered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class MemberBusinessController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchStatus = $request->input('search-status');

        $members = BusinessMember::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('business_name', 'like', "%{$search}%")
                        ->orWhere('business_code', 'like', "%{$search}%")
                        ->orWhere('phone_zalo', 'like', "%{$search}%")
                        ->orWhere('representative_full_name', 'like', "%{$search}%")
                        ->orWhere('representative_phone', 'like', "%{$search}%");
                });
            })
            ->when($searchStatus, function ($query, $searchStatus) {
                return $query->where('status', $searchStatus);
            })
            ->latest()
            ->paginate(15);
        return view('admin.pages.client.form-member.index', compact('members'));
    }

    public function showFormMemberBusiness()
    {
        $business_fields = BusinessField::all();
        return view('pages.client.gv.form-member-business', compact('business_fields'));
    }

    public function storFormMemberBusiness(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_code' => 'required|regex:/^\d{10}(-\d{3})?$/|unique:business_registrations,business_code',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_zalo' => 'required|string|max:10|regex:/^[0-9]+$/',
            'business_field_id' => 'nullable|array',
            'business_field_id.*' => 'nullable|exists:business_fields,id',
            'representative_full_name' => 'required|string|max:255',
            'representative_phone' => 'required|string|max:10|regex:/^[0-9]+$/',
            'link' => 'nullable|url',
        ], [
            'business_name.required' => 'Vui lòng nhập tên doanh nghiệp',
            'business_code.required' => 'Vui lòng nhập mã số thuế',
            'business_code.regex' => 'Mã số thuế không hợp lệ',
            'business_code.unique' => 'Mã số thuế đã tồn tại',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'email.email' => 'Email không hợp lệ',
            'phone_zalo.required' => 'Vui lòng nhập số điện thoại zalo',
            'phone_zalo.regex' => 'Số điện thoại zalo không hợp lệ',
            'business_field_id.required' => 'Vui lòng chọn ít nhất một ngành nghề.',
            'business_field_id.*.required' => 'Mỗi ngành nghề được chọn là bắt buộc.',
            'business_field_id.*.exists' => 'Ngành nghề :input không tồn tại.',
            'business_field_id.array' => 'Dữ liệu ngành nghề không hợp lệ.',
            'representative_full_name.required' => 'Vui lòng nhập tên người đại diện',
            'representative_phone.required' => 'Vui lòng nhập số điện thoại người đại diện',
            'representative_phone.regex' => 'Số điện thoại người đại diện không hợp lệ',
            'link.url' => 'Link không hợp lệ',
        ]);


        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = env('RECAPTCHA_SECRET_KEY');
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
        ]);
        $responseBody = json_decode($response->body());


        if (!$responseBody->success) {
            return redirect()->back()->withErrors(['recaptcha' => 'Vui lòng xác nhận bạn không phải là robot.'])->withInput();
        }


        $businessMember = new BusinessMember();
        $businessMember->fill($request->only([
            'business_name',
            'business_code',
            'address',
            'email',
            'phone_zalo',
            'representative_full_name',
            'representative_phone',
            'link',
        ]));
        $businessMember->business_field_id = json_encode($request->input('business_field_id'));
        $businessMember->status = "approved";

        try {

            $businessMember->save();

            $user = User::updateOrCreate(
                // Điều kiện kiểm tra user tồn tại
                ['username' => $businessMember->business_code],
                // Dữ liệu cần cập nhật hoặc tạo mới
                [
                    'password' => bcrypt($businessMember->business_code),
                    'full_name' => $businessMember->business_name,
                    'email' => $businessMember->email,
                    'role' => 'business',
                    'business_member_id' => $businessMember->id
                ]
            );

            DB::commit();
            $businessMember = BusinessMember::with('businessField')->findOrFail($businessMember->id);
            $businessFieldIds = json_decode($businessMember->business_field_id, true);
            $businessFields = [];
            if (!empty($businessFieldIds)) {
                $businessFields = BusinessField::whereIn('id', $businessFieldIds)->get();
            }
            $businessMember->business_field_id = (count($businessFields) > 0) ? $businessFields->pluck('name')->toArray() : [];
            $businessMember->subject = 'Đăng ký tham gia app';
            try {
                Mail::to('tri2003bt@gmail.com')->send(new BusinessRegistered($businessMember));
            } catch (\Exception $e) {
                Log::error('Email Sending Error:', [
                    'message' => $e->getMessage()
                ]);
            }

            $request->session()->put('business_code', $businessMember->business_code);
    
            $encryptedBusinessCode = $this->encrypt($businessMember->business_code, "E-Business@$^$%^");
            $request->session()->put('key_business_code', $encryptedBusinessCode);

            $intendedRoute = session('intended_route', route('show.form.member.business'));

            if($intendedRoute){
                return redirect($intendedRoute)->with('success', 'Đăng ký thành viên thành công!');
            }
            return redirect()->back()->with('success', 'Đăng ký thành viên thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đăng ký thành viên thất bại!' . $e->getMessage())->withInput();
        }
    }

    function encrypt($data, $key) {
        $cipher = "aes-256-cbc";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
        $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
    
    function decrypt($data, $key) {
        $cipher = "aes-256-cbc";
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
    }


    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID format'], 400);
        }

        try {
            $member = BusinessMember::with('businessField')->findOrFail($id);
            $businessFieldIds = json_decode($member->business_field_id, true);
            $businessFields = [];
            if (!empty($businessFieldIds)) {
                $businessFields = BusinessField::whereIn('id', $businessFieldIds)->get();
            }
            $member->business_field_id = (count($businessFields) > 0) ? $businessFields->pluck('name')->toArray() : [];
            return response()->json([
                'id' => $member->id,
                'business_name' => $member->business_name,
                'business_code' => $member->business_code,
                'phone_zalo' => $member->phone_zalo,
                'email' => $member->email,
                'business_field' => $member->business_field_id,
                'address' => $member->address,
                'representative_full_name' => $member->representative_full_name,
                'representative_phone' => $member->representative_phone,
                'created_at' => $member->created_at,
                'status' => $member->status,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch member details'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $member = BusinessMember::findOrFail($id);
            $member->delete();

            return redirect()->route('members.index')->with('success', 'Xóa thành công doanh nghiệp');
        } catch (\Exception $e) {

            return redirect()->route('members.index')->with('error', 'Xóa thất bại doanh nghiệp');
        }
    }
}
