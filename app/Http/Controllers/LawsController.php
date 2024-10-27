<?php

namespace App\Http\Controllers;

use App\Models\LegalAdvice;
use Illuminate\Http\Request;

class LawsController extends Controller
{
    //
    public function showFormLegal(){
        return view('pages.client.gv.form-law');
    }

    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'advice_content' => 'required|string',
        ], [
            'name.required' => 'Họ và tên là bắt buộc.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.max' => 'Số điện thoại không được vượt quá 10 số.',
            'email.required' => 'Email là bắt buộc.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'company_name.required' => 'Tên công ty/đơn vị là bắt buộc.',
            'advice_content.required' => 'Nội dung cần tư vấn là bắt buộc.',
        ]);

        LegalAdvice::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'company_name' => $validated['company_name'],
            'advice_content' => $validated['advice_content'],
        ]);

        return redirect()->back()->with('success', 'Yêu cầu tư vấn đã được gửi thành công!');
    }
}
