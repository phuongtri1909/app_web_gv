<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Email;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Mail\BusinessRegistered;
use App\Models\CategoryBusiness;
use App\Models\FinancialSupport;
use Illuminate\Support\Facades\DB;
use App\Models\BusinessCapitalNeed;
use Illuminate\Support\Facades\Log;
use App\Models\BankServicesInterest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BusinessMemberExport;
use App\Exports\CapitalNeedExport;
use App\Mail\BusinessCapitalNeedMail;
use App\Models\BusinessField;
use Illuminate\Validation\ValidationException;

class BusinessCapitalNeedController extends Controller
{

    public function reportBusinessCapitalNeeds(Request $request){
        $query = BusinessCapitalNeed::query();

        if ($request->filled('date_range')) {
            $dateRange = $request->input('date_range');
            $dates = explode(' - ', $dateRange);

            if (count($dates) === 2) {
                [$startDate, $endDate] = $dates;
                if (Carbon::hasFormat($startDate, 'Y-m-d') && Carbon::hasFormat($endDate, 'Y-m-d')) {
                    $query->whereDate('created_at', '>=', Carbon::parse($startDate))
                        ->whereDate('created_at', '<=', Carbon::parse($endDate));
                }
            }
        }

        $CapitalNeeds = $query->orderBy('created_at', 'desc')->get();

        if ($CapitalNeeds->isEmpty()) {
            return redirect()->back()->with('error', 'Không có bản ghi nào để xuất.');
        }

        foreach ($CapitalNeeds as $key => $value) {
            $business_fields_id = json_decode($value->businessMember->business_field_id, true);
          
            if ($business_fields_id) {
                $value->business_fields = BusinessField::whereIn('id', $business_fields_id)->pluck('name')->toArray();
               
            }

        }

        $currentDate = Carbon::now()->format('Y-m-d');
        $fileName = 'report_nhu_cau_von_' . $currentDate . '.xlsx';
        return Excel::download(new CapitalNeedExport($CapitalNeeds), $fileName);
    }

    //
    public function index(Request $request)
    {
        $search = $request->input('search');

        $search_status = $request->input('search-status');

        $query = BusinessCapitalNeed::query();

        if ($search) {
            $query->whereHas('businessMember', function ($query) use ($search) {
                $query->where('business_name', 'like', "%{$search}%")
                    ->orWhere('business_code', 'like', "%{$search}%");
            });
        }

        if ($search_status) {
            $query->where('email_status', $search_status);
        }

        $capitalNeeds = $query->orderBy('created_at', 'desc')->paginate(15);

        $emails = Email::where('type', '!=', 'ncb')->get();
        $emailTemplates = EmailTemplate::where('name',  '!=', 'ncb')->get();
        return view('admin.pages.client.form-capital-needs.index', compact('capitalNeeds', 'emails', 'emailTemplates'));
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
        $templateContent = $this->getEmailTemplate('ncb');
        if (!$templateContent) {
            return redirect()->back()->with('error', 'Mẫu email không tồn tại.');
        }
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
            $businessInfo = $businessCapitalNeed->businessMember;
            $emailBody = str_replace(
                ['{{ finance }}', '{{ loan_cycle }}', '{{ interest_rate }}', '{{ purpose }}', '{{ bank_connection }}', '{{ support_policy }}', '{{ feedback }}', '{{ business_name }}', 
                '{{ business_code }}', '{{ representative_full_name }}', '{{ representative_phone }}', '{{ address }}'],
                [
                    number_format($businessCapitalNeed->finance, 0, ',', '.') ?? 0,
                    $businessCapitalNeed->loan_cycle ?? 0,
                    $businessCapitalNeed->interest_rate ?? 0,
                    $businessCapitalNeed->purpose ?? 'Không có phản hồi',
                    $businessCapitalNeed->bank_connection ?? 'Không có phản hồi',
                    $businessCapitalNeed->support_policy ?? 'Không có phản hồi',
                    $businessCapitalNeed->feedback ?? 'Không có phản hồi',
                    $businessInfo->business_name ?? 'Không có tên doanh nghiệp',
                    $businessInfo->business_code ?? 'Không có mã doanh nghiệp',
                    $businessInfo->representative_full_name ?? 'Không có đại diện',
                    $businessInfo->representative_phone ?? 'Không có số điện thoại đại diện',
                    $businessInfo->address ?? 'Không có địa chỉ'
                ],
                $templateContent
            );

            $email = Email::where('type', 'ncb')->first();
            $businessCapitalNeed->subject = "Đăng ký nhu cầu vốn";

            if($email && $email->type == 'ncb'){
                try {
                    Mail::to($email->email)->send(new BusinessCapitalNeedMail($businessCapitalNeed, $emailBody,$email));
                } catch (\Exception $mailException) {
                    Log::error('Email Sending Exception: ' . $mailException->getMessage());
                }
            }
            DB::commit();
            
            return redirect()->route('show.home.bank')->with('success', 'Đăng ký kết nối ngân hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đăng ký thất bại: ' . $e->getMessage())->withInput();
        }
    }
    public function sendEmailToBank(Request $request)
    {
        // Log::info('sendEmailToBank');
        // Log::info($request->all());
    
        $capitalNeedId = $request->input('capital_need_id');
        $businessCapitalNeed = BusinessCapitalNeed::findOrFail($capitalNeedId);
    
        if ($businessCapitalNeed->email_status === 'sent') {
            return response()->json(['success' => false, 'error' => 'Email đã được gửi trước đó.']);
        }
    
        $bankEmail = $request->input('email');
        if (empty($bankEmail) || !filter_var($bankEmail, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['success' => false, 'error' => 'Email không hợp lệ.']);
        }
    
        $templateId = $request->input('email_template');
        $bankName = Email::where('email', $bankEmail)->value('bank_name') ?? 'Không xác định';
        $template = EmailTemplate::find($templateId);
    
        if (!$template || empty($template->content)) {
            return response()->json(['success' => false, 'error' => 'Mẫu email không tồn tại hoặc nội dung bị rỗng.']);
        }
    
        $templateContent = $template->content;
        $businessInfo = $businessCapitalNeed->businessMember;
    
        $emailBody = str_replace(
            ['{{ bank_name }}', '{{ finance }}', '{{ loan_cycle }}', '{{ interest_rate }}', '{{ purpose }}', '{{ bank_connection }}', '{{ support_policy }}', '{{ feedback }}', '{{ business_name }}', 
            '{{ business_code }}', '{{ representative_full_name }}', '{{ representative_phone }}', '{{ address }}'],
            [
                $bankName,
                number_format($businessCapitalNeed->finance, 0, ',', '.') ?? 0,
                $businessCapitalNeed->loan_cycle ?? 0,
                $businessCapitalNeed->interest_rate ?? 0,
                $businessCapitalNeed->purpose ?? 'Không có phản hồi',
                $businessCapitalNeed->bank_connection ?? 'Không có phản hồi',
                $businessCapitalNeed->support_policy ?? 'Không có phản hồi',
                $businessCapitalNeed->feedback ?? 'Không có phản hồi',
                $businessInfo->business_name ?? 'Không có tên doanh nghiệp',
                $businessInfo->business_code ?? 'Không có mã doanh nghiệp',
                $businessInfo->representative_full_name ?? 'Không có đại diện',
                $businessInfo->representative_phone ?? 'Không có số điện thoại đại diện',
                $businessInfo->address ?? 'Không có địa chỉ'
            ],
            $templateContent
        );
    
        try {
            Mail::to($bankEmail)->send(new BusinessCapitalNeedMail($businessCapitalNeed, $emailBody));
            $businessCapitalNeed->email_status = 'sent';
            $businessCapitalNeed->save();
            return response()->json(['success' => true, 'message' => 'Gửi email thành công']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi gửi email: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Đã xảy ra lỗi khi gửi email.']);
        }
    }
    

    public function getEmailTemplate($type, $keyName = null)
    {
        $query = Email::where('type', $type);
        if ($keyName) {
            $query->where('key_name', $keyName);
        }

        $email = $query->first();

        if ($email && $email->template) {
            return $email->template->content;
        }
        return null;
    }


}
