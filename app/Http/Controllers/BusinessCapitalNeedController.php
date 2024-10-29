<?php

namespace App\Http\Controllers;

use App\Models\BankServicesInterest;
use App\Models\Business;
use App\Models\BusinessCapitalNeed;
use App\Models\CategoryBusiness;
use App\Models\FinancialSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException ;
class BusinessCapitalNeedController extends Controller
{
    //
    public function index()
    {
        $capitalNeeds = BusinessCapitalNeed::with(['business', 'financialSupport', 'bankServicesInterest'])->get();
        return view('admin.pages.client.form-capital-needs.index', compact('capitalNeeds'));
    }

    public function create()
    {
        $categoryBusinesses = CategoryBusiness::all();
        $financialSupports = FinancialSupport::all();
        $bankServices = BankServicesInterest::all();
        return view('admin.pages.client.capital-needs.create', compact('categoryBusinesses', 'financialSupports', 'bankServices'));
    }

    public function edit($id)
    {
        $capitalNeed = BusinessCapitalNeed::with(['business', 'financialSupport', 'bankService'])->findOrFail($id);
        $categoryBusinesses = CategoryBusiness::all();
        $financialSupports = FinancialSupport::all();
        $bankServices = BankServicesInterest::all();
        return view('admin.pages.client.capital-needs.edit', compact('capitalNeed', 'categoryBusinesses', 'financialSupports', 'bankServices'));
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID format'], 400);
        }

        try {
            $capitalNeed = BusinessCapitalNeed::with([
                'business.categoryBusiness',
                'business.field',
                'business.ward',
                'financialSupport',
                'bankServicesInterest'
            ])->findOrFail($id);
    
            return response()->json([
                'id' => $capitalNeed->id,
                'business_name' => $capitalNeed->business->business_name,
                'business_code' => $capitalNeed->business->business_code,
                'representative_name' => $capitalNeed->business->representative_name,
                'birth_year' => $capitalNeed->business->birth_year,
                'gender' => $capitalNeed->business->gender,
                'phone_number' => $capitalNeed->business->phone_number,
                'fax_number' => $capitalNeed->business->fax_number,
                'email' => $capitalNeed->business->email,
                'social_channel' => $capitalNeed->business->social_channel,
                'address' => $capitalNeed->business->address,
                'business_address' => $capitalNeed->business->business_address,
                'ward' => $capitalNeed->business->ward,
                'category_business' => $capitalNeed->business->categoryBusiness,
                'business_field' => $capitalNeed->business->field,
                'description' => $capitalNeed->business->description,
                'avt_businesses' => $capitalNeed->business->avt_businesses,
                'business_license' => $capitalNeed->business->business_license,
                'finance' => $capitalNeed->finance,
                'interest_rate' => $capitalNeed->interest_rate,
                'mortgage_policy' => $capitalNeed->mortgage_policy,
                'unsecured_policy' => $capitalNeed->unsecured_policy,
                'purpose' => $capitalNeed->purpose,
                'bank_connection' => $capitalNeed->bank_connection,
                'feedback' => $capitalNeed->feedback,
                'status' => $capitalNeed->status,
                'financial_support' => $capitalNeed->financialSupport,
                'bank_service' => $capitalNeed->bankService,
                'created_at' => $capitalNeed->created_at,
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch details'], 500);
        }
    }
    

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $capitalNeed = BusinessCapitalNeed::findOrFail($id);
            $capitalNeed->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Xóa đăng ký vốn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Xóa thất bại: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $capitalNeed = BusinessCapitalNeed::findOrFail($id);
            $validatedData = $request->validate([
                'interest_rate' => 'required|numeric|min:0',
                'finance' => 'required|numeric|min:0',
                'mortgage_policy' => 'required|string|max:1000',
                'unsecured_policy' => 'required|string|max:1000',
                'purpose' => 'required|string|max:1000',
                'bank_connection' => 'required|string',
                'feedback' => 'nullable|string|max:1000',
                'status' => 'required|in:pending,approved,rejected'
            ]);

            $capitalNeed->update($validatedData);
            DB::commit();
            return redirect()->route('capital-needs.index')->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Cập nhật thất bại: ' . $e->getMessage())->withInput();
        }
    }

    public function showFormCapitalNeeds($slug = null){
        $category_business = CategoryBusiness::all();
        if ($slug) {
            $financialSupport = FinancialSupport::where('slug',$slug);
            if ($financialSupport) {
                    return view('pages.client.gv.registering-capital-needs', compact(  'slug','category_business'));
            }
            else{
                $bank_service = BankServicesInterest::where('slug',$slug);
                if ($bank_service) {
                    return view('pages.client.gv.registering-capital-needs', compact(  'slug','category_business'));
                }
            }
            return redirect()->route('show.home.bank')->with('error', __('Dịch vụ không tồn tại!!.'));
        }
          return view('pages.client.gv.registering-capital-needs',compact('category_business'));
    }
    public function storeFormCapitalNeeds(Request $request)
    {
        DB::beginTransaction();
        try{
            $validatedData = $request->validate([
                'representative_name' => 'required|string|max:255',
                'gender' => 'required|in:male,female,other',
                'phone_number' => 'required|string|max:10|regex:/^[0-9]+$/',
                'fax' => 'nullable|string|regex:/^(\+?\d{1,3})?[-.\s]?\(?\d{1,4}\)?[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/',
                'business_address' => 'required|string|max:255',
                'category_business_id' => 'required|exists:category_business,id',
                'business_name' => 'required|string|max:255',
                'business_code' => 'required|regex:/^\d{10,13}$/',
                'email' => 'nullable|email|max:255',
                'interest_rate' => 'required|numeric|min:0',
                'finance' => 'required|numeric|min:0',
                'mortgage_policy' => 'required|string|max:1000',
                'unsecured_policy' => 'required|string|max:1000',
                'purpose' => 'required|string|max:1000',
                'bank_connection' => 'required|string',
                'feedback' => 'nullable|string|max:1000',
            ], [
                'business_name.required' => 'Vui lòng nhập tên doanh nghiệp.',
                'business_code.required' => 'Mã số doanh nghiệp là bắt buộc.',
                'business_code.regex' => 'Mã số doanh nghiệp không hợp lệ,ít nhất 10 hoặc không vượt quá 13 số',
                'category_business_id.required' => 'Vui lòng chọn loại hình kinh doanh.',
                'category_business_id.exists' => 'Loại hình kinh doanh không hợp lệ.',
                'phone_number.required' => 'Số điện thoại là bắt buộc.',
                'phone_number.max' => 'Số điện thoại không được vượt quá 10 chữ số.',
                'phone_number.regex' => 'Số điện thoại chỉ được phép chứa các ký tự số.',
                'fax.regex' => 'Định dạng số fax không hợp lệ.',
                'email.email' => 'Định dạng email không đúng.',
                'representative_name.required' => 'Vui lòng nhập tên người đại diện.',
                'gender.required' => 'Vui lòng chọn giới tính.',
                'gender.in' => 'Giới tính không hợp lệ.',
                'interest_rate.numeric' => 'Lãi suất phải là một số hợp lệ.',
                'interest_rate.required' => 'Vui lòng nhập lãi suất.',
                'interest_rate.min' => 'Lãi suất không được nhỏ hơn 0',
                'finance.numeric' => 'Số tiền tài chính phải là một số hợp lệ.',
                'finance.required' => 'Vui lòng nhập số tiền tài chính.',
                'finance.min' => 'Số tiền tài chính không được nhỏ hơn 0',
                'feedback.max' => 'Phản hồi không được vượt quá 1000 ký tự.',
                'purpose.required' => 'Vui lòng nhập mục đích của bạn.',
                'bank_connection.required' => 'Vui lòng nhập thông tin kết nối ngân hàng.',
                'mortgage_policy.required' => 'Vui lòng cung cấp chính sách thế chấp.',
                'unsecured_policy.required' => 'Vui lòng cung cấp chính sách tín chấp.',
                'unsecured_policy.max' => 'Tín chấp không được vượt quá 1000 ký tự.',
                'mortgage_policy.max' => 'Thế chấp không được vượt quá 1000 ký tự.',
                'purpose.max' => 'Mục đích không được vượt quá 1000 ký tự.',
                'business_address.required' => 'Vui lòng nhập địa chỉ doanh nghiệp',
                'business_address.max' => 'Địa chỉ doanh nghiệp không vượt quá 255 ký tự',
            ]);
            $existingBusiness = Business::where('business_code', $validatedData['business_code'])->first();
            if ($existingBusiness) {
             $response = $this->validateExistingBusiness($existingBusiness, $validatedData);
            if ($response) return $response;
            $existingInvestment = BusinessCapitalNeed::where('business_id', $existingBusiness->id)->first();
            if ($existingInvestment) {
                return redirect()->back()->with('error', 'Doanh nghiệp này đã đăng ký trước đó.')->withInput();
            }
            BusinessCapitalNeed::create([
                'business_id' => $existingBusiness->id,
                'interest_rate' => $validatedData['interest_rate'],
                'finance' => $validatedData['finance'],
                'mortgage_policy' => $validatedData['mortgage_policy'],
                'unsecured_policy' => $validatedData['unsecured_policy'],
                'purpose' => $validatedData['purpose'],
                'bank_connection' => $validatedData['bank_connection'],
                'feedback' => $validatedData['feedback'],
                'financial_support_id' => $request->has('slug') && ($financialSupport = FinancialSupport::where('slug', $request->slug)->first()) ? $financialSupport->id : null,
                'bank_service_id' => $request->has('slug') && ($bankService = BankServicesInterest::where('slug', $request->slug)->first()) ? $bankService->id : null
            ]);


            DB::commit();
            return redirect()->back()->with('success', 'Đã thêm Đăng ký vốn cho doanh nghiệp hiện có.');
        }

        $response = $this->checkForExistingEmail($validatedData['email']);
        if ($response) return $response;

        $business = Business::create([
            'business_name' => $validatedData['business_name'],
            'business_code' => $validatedData['business_code'],
            'business_address' => $validatedData['business_address'],
            'representative_name' => $validatedData['representative_name'],
            'category_business_id' => $validatedData['category_business_id'],
            'fax' => $validatedData['fax'],
            'gender' => $validatedData['gender'],
            'phone_number' => $validatedData['phone_number'],
            'email' => $validatedData['email'],
            'status' => 'other'
        ]);

        BusinessCapitalNeed::create([
                'business_id' => $business->id,
                'interest_rate' => $validatedData['interest_rate'],
                'finance' => $validatedData['finance'],
                'mortgage_policy' => $validatedData['mortgage_policy'],
                'unsecured_policy' => $validatedData['unsecured_policy'],
                'purpose' => $validatedData['purpose'],
                'bank_connection' => $validatedData['bank_connection'],
                'feedback' => $validatedData['feedback'],
                'financial_support_id' => $request->has('slug') && ($financialSupport = FinancialSupport::where('slug', $request->slug)->first()) ? $financialSupport->id : null,
                'bank_service_id' => $request->has('slug') && ($bankService = BankServicesInterest::where('slug', $request->slug)->first()) ? $bankService->id : null
        ]);

        DB::commit();
        return redirect()->back()->with('success', 'Đăng ký vốn thành công!');
        }catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đăng ký thất bại: ' . $e->getMessage())->withInput();
        }
    }
    private function validateExistingBusiness($existingBusiness, $validatedData)
    {
        if ($existingBusiness->business_name !== $validatedData['business_name'] ||
            $existingBusiness->business_address !== $validatedData['business_address'] ||
            $existingBusiness->phone_number !== $validatedData['phone_number'] ||
            $existingBusiness->email !== $validatedData['email'] ||
            $existingBusiness->representative_name !== $validatedData['representative_name']) {

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
