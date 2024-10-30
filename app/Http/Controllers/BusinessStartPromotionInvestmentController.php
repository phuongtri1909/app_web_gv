<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessField;
use App\Models\BusinessStartPromotionInvestment;
use App\Models\BusinessSupportNeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // dd($request->all());
        try {
            $validatedData = $request->validate([
                'representative_name' => 'required|string|max:255',
                'birth_year' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
                'gender' => 'required|in:male,female,other',
                'phone_number' => 'required|string|max:10|regex:/^[0-9]+$/',
                'address' => 'required|string|max:255',
                'business_address' => 'required|string|max:255',
                'business_name' => 'required|string|max:255',
                'business_code' => 'required|regex:/^\d{10,13}$/',
                'email' => 'required|email|max:255',
                'social_channel' => 'nullable|url|max:255',
                'support_need' => 'required|exists:business_support_needs,id',
                'business_fields' => 'required|exists:business_fields,id',
            ], [
                'business_code.unique' => 'Mã doanh nghiệp này đã đăng ký trong hệ thống.',
                'business_code.regex' => 'Mã số doanh nghiệp/Mã số thuế không được ít hơn 10 và nhiều hơn 13 số.',
                'business_name.required' => 'Tên doanh nghiệp là bắt buộc.',
                'representative_name.required' => 'Tên người đại diện là bắt buộc.',
                'birth_year.required' => 'Năm sinh là bắt buộc.',
                'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
                'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
                'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
                'gender.required' => 'Giới tính là bắt buộc.',
                'phone_number.required' => 'Số điện thoại là bắt buộc.',
                'phone_number.regex' => 'Số điện thoại không hợp lệ.',
                'phone_number.max' => 'Số điện thoại không được vượt quá 10 số.',
                'address.required' => 'Địa chỉ là bắt buộc.',
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email không hợp lệ.',
                'email.unique' => 'Email này đã được đăng ký trong hệ thống.',
                'social_channel.url' => 'Đường dẫn social không hợp lệ.',
                'support_need.required' => 'Vui lòng chọn nhu cầu hỗ trợ.',
                'support_need.exists' => 'Nhu cầu hỗ trợ không hợp lệ.',
                'business_fields.required' => 'Vui lòng chọn ngành nghề.',
                'business_fields.exists' => 'Ngành nghề không hợp lệ.',
            ]);

            $existingBusiness = Business::where('business_code', $validatedData['business_code'])->first();
            if ($existingBusiness) {
                $response = $this->validateExistingBusiness($existingBusiness, $validatedData);
                if ($response) return $response;
                $existingInvestment = BusinessStartPromotionInvestment::where('business_id', $existingBusiness->id)->first();
                if ($existingInvestment) {
                    return redirect()->back()->with('error', 'Doanh nghiệp này đã đăng ký trước đó.')->withInput();
                }
                BusinessStartPromotionInvestment::create([
                    'business_support_needs_id' => $validatedData['support_need'],
                    'business_id' => $existingBusiness->id,
                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Đã thêm Khởi nghiệp-Xúc tiến thương mại-Kêu gọi đầu tư cho doanh nghiệp hiện có.');
            }
            $response = $this->checkForExistingEmail($validatedData['email']);
            if ($response) return $response;
            $business = Business::create([
                'business_name' => $validatedData['business_name'],
                'business_code' => $validatedData['business_code'],
                'business_address' => $validatedData['business_address'],
                'business_fields' => $validatedData['business_fields'] ?? null,
                'representative_name' => $validatedData['representative_name'],
                'birth_year' => $validatedData['birth_year'],
                'gender' => $validatedData['gender'],
                'phone_number' => $validatedData['phone_number'],
                'address' => $validatedData['address'],
                'email' => $validatedData['email'],
                'social_channel' => $validatedData['social_channel'] ?? null,
                'status' => 'other'
            ]);

            BusinessStartPromotionInvestment::create([
                'business_support_needs_id' => $validatedData['support_need'],
                'business_id' => $business->id,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Đăng ký Khởi nghiệp-Xúc tiến thương mại-Kêu gọi đầu tư thành công!');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đăng ký thất bại: ' . $e->getMessage())->withInput();
        }
    }
    public function index()
    {
        $promotions = BusinessStartPromotionInvestment::with(['business', 'supportNeeds'])->get();
        return view('admin.pages.client.form-start-promotion-invertment.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.pages.client.form-start-promotion-invertment.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'business_support_needs_id' => 'required|exists:business_support_needs,id'
        ]);

        BusinessStartPromotionInvestment::create($validatedData);
        return redirect()->route('client.form-start-promotion-invertment.index')->with('success', 'Thêm mới thành công');
    }

    public function show($id)
    {
        $promotion = BusinessStartPromotionInvestment::with([
            'business.categoryBusiness',
            'business.field',
            'business.ward',
            'supportNeeds'
        ])->findOrFail($id);
        
        return response()->json([
            'id' => $promotion->id,
            'business_name' => $promotion->business->business_name,
            'business_code' => $promotion->business->business_code,
            'representative_name' => $promotion->business->representative_name,
            'birth_year' => $promotion->business->birth_year,
            'gender' => $promotion->business->gender,
            'phone_number' => $promotion->business->phone_number,
            'fax_number' => $promotion->business->fax_number,
            'email' => $promotion->business->email,
            'social_channel' => $promotion->business->social_channel,
            'address' => $promotion->business->address,
            'business_address' => $promotion->business->business_address,
            'ward' => $promotion->business->ward,
            'category_business' => $promotion->business->categoryBusiness,
            'business_field' => $promotion->business->field,
            'description' => $promotion->business->description,
            'avt_businesses' => $promotion->business->avt_businesses,
            'business_license' => $promotion->business->business_license,
            'supportNeeds' => $promotion->supportNeeds,
            'status' => $promotion->status,
            'created_at' => $promotion->created_at
        ]);
    }
    


    public function edit($id)
    {
        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        return view('admin.pages.client.form-start-promotion-invertment.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'business_support_needs_id' => 'required|exists:business_support_needs,id'
        ]);

        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        $promotion->update($validatedData);
        return redirect()->route('client.form-start-promotion-invertment.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        $promotion->delete();
        return redirect()->route('client.form-start-promotion-invertment.index')->with('success', 'Xóa thành công');
    }
}

