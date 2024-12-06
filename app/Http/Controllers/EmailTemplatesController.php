<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplatesController extends Controller
{
    /**
     * Hiển thị danh sách tất cả mẫu email.
     *
     * 
     */
    public function index()
    {
    
        $templates = EmailTemplate::all();
        return view('admin.pages.email_templates.index', compact('templates'));
    }

    /**
     * Hiển thị form tạo mới mẫu email.
     *
     * 
     */
    public function create()
    {
        return view('admin.pages.email_templates.create');
    }

    /**
     * Lưu mẫu email mới vào database.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:email_templates,name',
            'content' => 'nullable',
        ], [
            'name.required' => 'Tên mẫu email là bắt buộc.',
            'name.unique' => 'Tên mẫu email này đã tồn tại.',
        ]);
    
        try {
            EmailTemplate::create([
                'name' => $request->name,
                'content' => $request->content,
            ]);
            return redirect()->route('email_templates.index')->with('success', 'Mẫu email đã được tạo thành công!');
            
        } catch (\Exception $e) {
            return redirect()->route('email_templates.index')->with('error', 'Đã xảy ra lỗi trong quá trình tạo mẫu email: ' . $e->getMessage());
        }
    }
    

    /**
     * Hiển thị form chỉnh sửa mẫu email.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * 
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        if (!$emailTemplate->exists) {
            return redirect()->route('email_templates.index')->with('error', 'Mẫu email không tồn tại!');
        }

        return view('admin.pages.email_templates.edit', compact('emailTemplate'));
    }

    /**
     * Cập nhật mẫu email trong database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * 
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'name' => 'required|unique:email_templates,name,' . $emailTemplate->id,
            'content' => 'nullable',
        ], [
            'name.required' => 'Tên mẫu email là bắt buộc.',
            'name.unique' => 'Tên mẫu email này đã tồn tại.',
        ]);
    
        try {
            $emailTemplate->update([
                'name' => $request->name,
                'content' => $request->content,
            ]);
            return redirect()->route('email_templates.index')->with('success', 'Mẫu email đã được cập nhật!');
            
        } catch (\Exception $e) {
            return redirect()->route('email_templates.index')->with('error', 'Đã xảy ra lỗi trong quá trình cập nhật mẫu email: ' . $e->getMessage());
        }
    }
    

    /**
     * Xóa mẫu email.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * 
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        if (in_array($emailTemplate->name, ['bank', 'ncb'])) {
            return back()->with('error', 'Mẫu email ' . $emailTemplate->name . ' mặc định không thể xóa!');
        }

        if ($emailTemplate->isUsed()) {
            return back()->with('error', 'Mẫu email đang được sử dụng và không thể xóa!');
        }

        $emailTemplate->delete();

        return redirect()->route('email_templates.index')->with('success', 'Mẫu email đã được xóa!');
    }
}
