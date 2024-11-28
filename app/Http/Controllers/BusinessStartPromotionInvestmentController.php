<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessField;
use App\Models\BusinessStartPromotionInvestment;
use App\Models\BusinessSupportNeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException ;
class BusinessStartPromotionInvestmentController extends Controller
{

    public function showFormStartPromotion(){
        $business_support_needs = BusinessSupportNeed::all();
        $business_fields = BusinessField::all();
        return view('pages.client.gv.start-promotion-investment',compact('business_support_needs','business_fields'));
    }
    public function storeFormStartPromotion(Request $request)
    {

        DB::beginTransaction();
    
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'birth_year' => [
                    'required',
                    'digits:4',
                    'integer',
                    'min:1500',
                    'max:' . date('Y'),
                    function ($attribute, $value, $fail) {
                        if ((date('Y') - $value) < 18) {
                            $fail('Năm sinh không hợp lệ, bạn phải trên 18 tuổi.');
                        }
                    },
                ],
                'gender' => 'required|in:male,female,other',
                'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
                'startup_address' => 'required|string|max:255',
                'business_fields' => 'required|exists:business_fields,id',
                'startup_activity_info' => 'nullable|string|max:500',
                'support_need' => 'required|array|min:1',
                'support_need.*' => 'required|exists:business_support_needs,id',
                // 'g-recaptcha-response' => 'required',
            ], [
                // 'g-recaptcha-response.required' => 'Vui lòng xác nhận bạn không phải là robot.',
                'support_need.required' => 'Vui lòng chọn ít nhất một nhu cầu hỗ trợ.',
                'support_need.*.exists' => 'Nhu cầu hỗ trợ bạn chọn không tồn tại.',
                'business_fields.required' => 'Vui lòng chọn ngành nghề.',
                'business_fields.exists' => 'Ngành nghề không hợp lệ.',
                'name.required' => 'Họ tên là bắt buộc.',
                'birth_year.required' => 'Năm sinh là bắt buộc.',
                'birth_year.min' => 'Năm sinh không hợp lệ, bạn không thể sinh trước năm 1500.',
                'birth_year.max' => 'Năm sinh không hợp lệ, bạn không thể sinh sau năm hiện tại.',
                'gender.required' => 'Giới tính là bắt buộc.',
                'gender.in' => 'Giới tính không hợp lệ, vui lòng chọn đúng giá trị.',
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ, chỉ được phép chứa từ 10 chữ số.',
                'startup_address.required' => 'Địa chỉ cư trú là bắt buộc.',
            ]);            
            // $recaptchaResponse = $request->input('g-recaptcha-response');
            // $secretKey = env('RECAPTCHA_SECRET_KEY');
            // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            //     'secret' => $secretKey,
            //     'response' => $recaptchaResponse,
            // ]);
            // $responseBody = json_decode($response->body());
    
            // if (!$responseBody->success) {
            //     return redirect()->back()->withErrors(['error' => 'Vui lòng xác nhận bạn không phải là robot.'])->withInput();
            // }
             BusinessStartPromotionInvestment::create([
                'name' => $validatedData['name'],
                'birth_year' => $validatedData['birth_year'],
                'gender' => $validatedData['gender'],
                'phone' => $validatedData['phone'],
                'startup_address' => $validatedData['startup_address'],
                'business_field' => $validatedData['business_fields'],
                'startup_activity_info' => $validatedData['startup_activity_info'] ?? null,
                'business_support_needs_id' => json_encode($validatedData['support_need']),
            ]);
            DB::commit();
    
            return redirect()->back()->with('success', 'Đăng ký nhu cầu khởi nghiệp thành công!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Đăng ký thất bại: ' . $e->getMessage())->withInput();
        }
    }
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $promotions = BusinessStartPromotionInvestment::when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
        })
        ->paginate(15);
        return view('admin.pages.client.form-start-promotion-invertment.index', compact('promotions'));
    }
    

    public function create()
    {
       
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        $supportNeedIds = json_decode($promotion->business_support_needs_id);
        $supportNeeds = BusinessSupportNeed::whereIn('id', $supportNeedIds)->pluck('name')->toArray();
        $businessField = BusinessField::find($promotion->business_field);
        return response()->json([
            'id' => $promotion->id,
            'name' => $promotion->name, 
            'birth_year' => $promotion->birth_year,
            'gender' => $promotion->gender,
            'phone' => $promotion->phone, 
            'startup_address' => $promotion->startup_address,
            'business_field' => $businessField->name ?? $promotion->business_field, 
            'startup_activity_info' => $promotion->startup_activity_info,
            'business_support_needs' => $supportNeeds,  
            'status' => $promotion->status,
            'created_at' => $promotion->created_at,
            'updated_at' => $promotion->updated_at,
        ]);
    }
    
    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        $promotion->delete();
        return redirect()->route('start-promotion-investment.index')->with('success', 'Xóa thành công');
    }
    private function validateExistingBusiness($existingBusiness, $validatedData)
    {
        if ($existingBusiness->business_name !== $validatedData['business_name'] ||
            $existingBusiness->email !== $validatedData['email'] ) {
            return redirect()->back()->with('error', 'Thông tin doanh nghiệp không khớp.')->withInput();
        }
    }

    private function checkForExistingEmail($email)
    {
        if (Business::where('email', $email)->exists()) {
            return redirect()->back()->with('error', 'Email này đã được đăng ký trong hệ thống với một doanh nghiệp khác.')->withInput();
        }
    }
}

