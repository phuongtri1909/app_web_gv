<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{

    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'fax' => 'nullable|string|max:255',
            'birth_year' => 'required|digits:4',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|max:255',
            'introduction' => 'required|string',
            'job_registration' => 'required|string',
        ], [
            'full_name.required' => 'Tên là bắt buộc.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.digits' => 'Số điện thoại phải có 10 chữ số.',
            'birth_year.required' => 'Năm sinh là bắt buộc.',
            'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'introduction.required' => 'Thông tin/giới thiệu bản thân là bắt buộc.',
            'job_registration.required' => 'Đăng ký tìm việc là bắt buộc.',
        ]);

        JobApplication::create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'fax' => $validated['fax'],
            'birth_year' => $validated['birth_year'],
            'gender' => $validated['gender'],
            'email' => $validated['email'],
            'introduction' => $validated['introduction'],
            'job_registration' => $validated['job_registration'],
        ]);

        return redirect()->back()->with('success', 'Gửi thành công!');
    }

    public function jobApplication()
    {
        return view('pages.client.form-job-application');
    }
}
