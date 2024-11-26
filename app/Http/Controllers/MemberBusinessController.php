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

    public function index()
    {
        $members = BusinessMember::latest()->paginate(10);
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
            'business_field_id' => 'required|exists:business_fields,id',
            'representative_full_name' => 'required|string|max:255',
            'representative_phone' => 'required|string|max:10|regex:/^[0-9]+$/',
        ], [
            'business_name.required' => 'Vui lòng nhập tên doanh nghiệp',
            'business_code.required' => 'Vui lòng nhập mã số thuế',
            'business_code.regex' => 'Mã số thuế không hợp lệ',
            'business_code.unique' => 'Mã số thuế đã tồn tại',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'email.email' => 'Email không hợp lệ',
            'phone_zalo.required' => 'Vui lòng nhập số điện thoại zalo',
            'phone_zalo.regex' => 'Số điện thoại zalo không hợp lệ',
            'business_field_id.required' => 'Vui lòng chọn lĩnh vực kinh doanh',
            'business_field_id.exists' => 'Lĩnh vực kinh doanh không hợp lệ',
            'representative_full_name.required' => 'Vui lòng nhập tên người đại diện',
            'representative_phone.required' => 'Vui lòng nhập số điện thoại người đại diện',
            'representative_phone.regex' => 'Số điện thoại người đại diện không hợp lệ',
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
            'business_field_id',
            'representative_full_name',
            'representative_phone',
        ]));

        $businessMember->status = "approved";

        try {

            $businessMember->save();

            $user = new User();
            $user->username = $businessMember->business_code;
            $user->password = bcrypt($businessMember->business_code);
            $user->full_name = $businessMember->business_name;
            $user->email = $businessMember->email;
            $user->role = 'business';
            $user->business_member_id = $businessMember->id;
            $user->save();

            DB::commit();

            $businessMember->subject = 'Đăng ký tham gia app';
            try {
                Mail::to('tri2003bt@gmail.com')->send(new BusinessRegistered($businessMember));
            } catch (\Exception $e) {
                Log::error('Email Sending Error:', [
                    'message' => $e->getMessage()
                ]);
            }
            return redirect()->back()->with('success', 'Đăng ký thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đăng ký thất bại!' . $e->getMessage())->withInput();
        }
    }


    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID format'], 400);
        }

        try {
            $member = BusinessMember::findOrFail($id);

            return response()->json([
                'id' => $member->id,
                'business_name' => $member->business_name,
                'business_code' => $member->business_code,
                'phone_zalo' => $member->phone_zalo,
                'email' => $member->email,
                'business_field' => $member->business_field,
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
}
