<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class EmailController extends Controller
{
    public function index()
    {
        $emails = Email::all();
        return view('admin.pages.emails.index', compact('emails'));
    }

    public function create()
    {
        $templates = EmailTemplate::where('name', '!=', 'ncb')->get();
        return view('admin.pages.emails.create',compact('templates'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:ncb,bank',
            'key_name' => 'required|unique:emails,key_name|max:50',
            'email' => 'required|email|max:255',
            'bank_name' => 'nullable|required_if:type,bank|max:255',
            'template_id' => 'nullable|exists:email_templates,id',
        ], [
            'type.required' => 'Loại email là bắt buộc.',
            'type.in' => 'Loại email phải là "ncb" hoặc "bank".',
            'key_name.required' => 'Tên khóa email là bắt buộc.',
            'key_name.unique' => 'Tên khóa email này đã tồn tại.',
            'key_name.max' => 'Tên khóa email không được vượt quá 50 ký tự.',
            'email.required' => 'Địa chỉ email là bắt buộc.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Địa chỉ email không được vượt quá 255 ký tự.',
            'bank_name.required_if' => 'Tên ngân hàng là bắt buộc khi loại là "bank".',
            'bank_name.max' => 'Tên ngân hàng không được vượt quá 255 ký tự.',
            'template_id.exists' => 'Mẫu email không tồn tại.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            $email = new Email();
            $email->type = $request->type;
            $email->key_name = $request->key_name;
            $email->email = $request->email;
            $email->bank_name = $request->bank_name;
            $email->template_id = $request->template_id;
            $email->save();
            return redirect()->route('emails.index')->with('success', 'Email đã được tạo thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra trong quá trình tạo email: ' . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        $email = Email::findOrFail($id);
        $templates = EmailTemplate::where('name', '!=', 'ncb')->get();
        return view('admin.pages.emails.edit',compact('templates','email'));
    }
    public function update(Request $request, $id)
    {
        $email = Email::findOrFail($id);
        $request->validate([
            'type' => 'required|in:ncb,bank',
            'key_name' => 'required|unique:emails,key_name,' . $email->id,
            'email' => 'required|email|max:255',
            'bank_name' => 'nullable|required_if:type,bank|max:255',
            'email_template' => 'nullable|string',
        ], [
            'type.required' => 'Loại email là bắt buộc.',
            'type.in' => 'Loại email phải là "ncb" hoặc "bank".',
            'key_name.required' => 'Tên khóa email là bắt buộc.',
            'key_name.unique' => 'Tên khóa email này đã tồn tại.',
            'key_name.max' => 'Tên khóa email không được vượt quá 50 ký tự.',
            'email.required' => 'Địa chỉ email là bắt buộc.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Địa chỉ email không được vượt quá 255 ký tự.',
            'bank_name.required_if' => 'Tên ngân hàng là bắt buộc khi loại là "bank".',
            'bank_name.max' => 'Tên ngân hàng không được vượt quá 255 ký tự.',
            'email_template.string' => 'Mẫu email phải là một chuỗi ký tự.',
        ]);
    
        try {
            $email->update($request->all());
    
            return back()->with('success', 'Email đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra trong quá trình cập nhật email: ' . $e->getMessage());
        }
    }
    

    public function destroy($id)
    {
        Email::findOrFail($id)->delete();
        return back()->with('success', 'Email deleted successfully.');
    }
}
