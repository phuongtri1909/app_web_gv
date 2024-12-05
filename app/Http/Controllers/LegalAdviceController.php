<?php


namespace App\Http\Controllers;

use App\Models\LegalAdvice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LegalAdviceController extends Controller
{
    public function showFormLegal(){
        return view('pages.client.gv.form-law');
    }

    public function storeForm(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
                'email' => 'nullable|email|max:255',
                'address' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'advice_content' => 'required|string',
            ], [
                'name.required' => 'Họ và tên là bắt buộc.',
                'name.string' => 'Họ và tên phải là chuỗi ký tự.',
                'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
                'phone.max' => 'Số điện thoại không được vượt quá 10 số.',
                'email.max' => 'Email không được vượt quá 255 ký tự.',
                'address.required' => 'Địa chỉ là bắt buộc.',
                'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
                'company_name.required' => 'Tên công ty/đơn vị là bắt buộc.',
                'company_name.string' => 'Tên công ty/đơn vị phải là chuỗi ký tự.',
                'company_name.max' => 'Tên công ty/đơn vị không được vượt quá 255 ký tự.',
                'advice_content.required' => 'Nội dung cần tư vấn là bắt buộc.',
                'advice_content.string' => 'Nội dung cần tư vấn phải là chuỗi ký tự.'
            ]);
    
            $recaptchaResponse = $request->input('g-recaptcha-response');
            $secretKey = env('RECAPTCHA_SECRET_KEY');
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $recaptchaResponse,
            ]);
    
            $responseBody = json_decode($response->body());
    
            if (!$responseBody->success) {
                return redirect()->back()->withErrors(['error' => 'Vui lòng xác nhận bạn không phải là robot.'])->withInput();
            }
    
            LegalAdvice::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'company_name' => $validated['company_name'],
                'advice_content' => $validated['advice_content'],
            ]);
    
            DB::commit();
            
            return redirect()->back()->with('success', 'Yêu cầu tư vấn đã được gửi thành công!');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gửi yêu cầu tư vấn thất bại: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $legalAdvices = LegalAdvice::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('company_name', 'like', "%{$search}%");
            });
        })
        ->paginate(10);

        return view('admin.pages.client.form-legal-advice.index', compact('legalAdvices'));
    }
    public function show($id)
    {
        $advice = LegalAdvice::findOrFail($id); 

        return response()->json([
            'name' => $advice->name,
            'phone' => $advice->phone,
            'email' => $advice->email,
            'address' => $advice->address,
            'company_name' => $advice->company_name,
            'advice_content' => $advice->advice_content,
            'status' => $advice->status, 
        ]);
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $legalAdvice = LegalAdvice::findOrFail($id);
            $legalAdvice->delete();
            DB::commit();
            return redirect()->route('form-legal-advice.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Xóa thất bại: ' . $e->getMessage());
        }
    }

}
