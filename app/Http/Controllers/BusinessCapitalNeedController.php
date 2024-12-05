<?php

namespace App\Http\Controllers;

use App\Mail\BusinessCapitalNeedMail;
use App\Models\BankServicesInterest;
use App\Models\Business;
use App\Models\BusinessCapitalNeed;
use App\Models\CategoryBusiness;
use App\Models\FinancialSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Mail\BusinessRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BusinessCapitalNeedController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');
        $capitalNeeds = BusinessCapitalNeed::with(['businessMember'])->when($search, function ($query, $search) {
            return $query->whereHas('business', function ($query) use ($search) {
                $query->where('business_name', 'like', "%{$search}%")
                    ->orWhere('business_code', 'like', "%{$search}%");
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(15);
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
            $capitalNeed = BusinessCapitalNeed::findOrFail($id);

            return response()->json([
                'id' => $capitalNeed->id,
                'business_name' => $capitalNeed->businessMember->business_name,
                'avt_businesses' => isset($capitalNeed->businessMember->business) ? $capitalNeed->businessMember->business->avt_businesses : 'images/business/business_default.webp',
                'business_code' => $capitalNeed->businessMember->business_code,
                
                'finance' => $capitalNeed->finance,
                'interest_rate' => $capitalNeed->interest_rate,
                'purpose' => $capitalNeed->purpose,
                'bank_connection' => $capitalNeed->bank_connection,
                'feedback' => $capitalNeed->feedback,
                'status' => $capitalNeed->status,
                'loan_cycle' => $capitalNeed->loan_cycle,
                'support_policy' => $capitalNeed->support_policy,
                'created_at' => $capitalNeed->created_at,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi không tìm thấy được chi tiết cho nhu cầu vay vốn này' . $e->getMessage()], 500);
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

    public function showFormCapitalNeeds($slug = null)
    {
        $category_business = CategoryBusiness::all();
        if ($slug) {
            $financialSupport = FinancialSupport::where('slug', $slug);
            if ($financialSupport) {
                return view('pages.client.gv.registering-capital-needs', compact('slug', 'category_business'));
            } else {
                $bank_service = BankServicesInterest::where('slug', $slug);
                if ($bank_service) {
                    return view('pages.client.gv.registering-capital-needs', compact('slug', 'category_business'));
                }
            }
            return redirect()->route('show.home.bank')->with('error', __('Dịch vụ không tồn tại!!.'));
        }
        return view('pages.client.gv.registering-capital-needs', compact('category_business'));
    }
    public function storeFormCapitalNeeds(Request $request)
    {

        // Check business code 
        $business_member_id = $this->getBusinessMemberId($request);


        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'finance' => 'required|numeric|min:0',
                'loan_cycle' => 'required|integer|min:0',
                'interest_rate' => 'required|numeric|min:0',
                'purpose' => 'required|string|max:4000',
                'bank_connection' => 'required|string|max:255',
                'support_policy' => 'required|string|max:4000',
                'feedback' => 'required|string|max:4000',
            ], [
                'finance.required' => 'Vui lòng nhập số vốn.',
                'finance.numeric' => 'Số vốn phải là một số hợp lệ.',
                'finance.min' => 'Số vốn không được nhỏ hơn 0.',
                'loan_cycle.required' => 'Vui lòng nhập chu kỳ vay.',
                'loan_cycle.integer' => 'Chu kỳ vay phải là một số hợp lệ.',
                'loan_cycle.min' => 'Chu kỳ vay không được nhỏ hơn 0.',
                'interest_rate.required' => 'Vui lòng nhập đề xuất lãi suất.',
                'interest_rate.numeric' => 'Lãi đề xuất suất phải là một số hợp lệ.',
                'interest_rate.min' => 'Lãi suất không được nhỏ hơn 0.',
                'purpose.required' => 'Vui lòng nhập mục đích vay của bạn.',
                'purpose.max' => 'Mục đích vay không được vượt quá 4000 ký tự.',
                'bank_connection.required' => 'Vui lòng nhập thông tin kết nối ngân hàng.',
                'bank_connection.max' => 'Thông tin kết nối ngân hàng không được vượt quá 255 ký tự.',
                'support_policy.required' => 'Vui lòng nhập đề xuất chính sách hỗ trợ.',
                'support_policy.max' => 'Đề xuất chính sách hỗ trợ không được vượt quá 4000 ký tự.',
                'feedback.required' => 'Vui lòng nhập ý kiến đối với ngân hàng.',
                'feedback.max' => 'Ý kiến đối với ngân hàng không được vượt quá 4000 ký tự.',

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




            $businessCapitalNeed = BusinessCapitalNeed::create([
                'business_member_id' => $business_member_id,
                'finance' => $request->finance,
                'loan_cycle' => $request->loan_cycle,
                'interest_rate' => $request->interest_rate,
                'purpose' => $request->purpose,
                'bank_connection' => $request->bank_connection,
                'support_policy' => $request->support_policy,
                'feedback' => $request->feedback,
            ]);

           
            $businessCapitalNeed->subject = "Đăng ký nhu cầu vốn";

            try {
                Mail::to('tri2003bt@gmail.com')->send(new BusinessCapitalNeedMail($businessCapitalNeed));
            } catch (\Exception $mailException) {
                Log::error('Email Sending Exception: ' . $mailException->getMessage());
            }


            DB::commit();
            
            return redirect()->route('show.home.bank')->with('success', 'Đăng ký kết nối ngân hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đăng ký thất bại: ' . $e->getMessage())->withInput();
        }
    }
   
}
