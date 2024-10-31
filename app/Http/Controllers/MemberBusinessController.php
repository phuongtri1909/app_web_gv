<?php

namespace App\Http\Controllers;

use App\Models\BusinessMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
class MemberBusinessController extends Controller
{

    public function index()
    {
        $members = BusinessMember::latest()->paginate(10);
        return view('admin.pages.member-business.index', compact('members'));
    }
    public function show($id){
        $member = BusinessMember::find($id);
        return view('admin.pages.member-business.show', compact('member'));
    }
    //
    public function showFormMemberBusiness()
    {
        return view('pages.client.gv.form-member-business');
    }
    public function storFormMemberBusiness(Request $request)
    {
        $data = [];

        $request->validate([
            'avt_businesses' => 'required|image|mimes:jpeg,png,jpg,gif',
            'representative_name' => 'required|string|max:255',
            'birth_year' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
            'gender' => 'required|string',
            'phone_number' => 'required|string|max:10|regex:/^[0-9]+$/',
            'address' => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'ward_id' => 'required|integer|exists:ward_govap,id',
            'business_name' => 'required|string|max:255',
            'business_license' => 'nullable|mimes:pdf',
            'business_code' => 'required|regex:/^\d{10}(-\d{3})?$/',
            'email' => 'required|email|max:255',
            'social_channel' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'business_fields' => 'required|exists:business_fields,id',
            'identity_card' =>  'required|string|max:12|regex:/^[0-9]+$/',
            'identity_card_issue_date' => 'required|date',
            'home_address' => 'required|string|max:255',
            'contact_phone' =>  'required|string|max:10|regex:/^[0-9]+$/',
            'representative_email' => 'required|email|max:255',
            'business_license_file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'identity_card_front_file' => 'required|image',
            'identity_card_back_file' => 'required|image',
        ], [
            'avt_businesses.required' => 'Ảnh đại diện doanh nghiệp là bắt buộc.',
            'avt_businesses.image' => 'Ảnh đại diện phải là một file hình ảnh.',
            'avt_businesses.mimes' => 'Ảnh đại diện phải có định dạng jpg, jpeg, png hoặc gif.',
            
            'representative_name.required' => 'Tên người đại diện pháp luật là bắt buộc.',
            
            'birth_year.required' => 'Năm sinh là bắt buộc.',
            'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
            'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
            'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
            
            'gender.required' => 'Giới tính là bắt buộc.',
            
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.regex' => 'Số điện thoại chỉ chứa số.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 10 chữ số.',
            
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            
            'business_address.required' => 'Địa chỉ doanh nghiệp là bắt buộc.',
            'business_address.max' => 'Địa chỉ doanh nghiệp không được vượt quá 255 ký tự.',
            
            'ward_id.required' => 'Vui lòng chọn phường.',
            'ward_id.exists' => 'Phường đã chọn không tồn tại.',
            
            'business_name.required' => 'Tên doanh nghiệp là bắt buộc.',
            
            'business_license.mimes' => 'Giấy phép kinh doanh phải là file dạng pdf.',
            
            'business_code.required' => 'Mã doanh nghiệp là bắt buộc.',
            'business_code.regex' => 'Mã doanh nghiệp phải có từ 10 đến 13 chữ số.',
            'business_code.unique' => 'Mã doanh nghiệp này đã tồn tại.',
            
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            
            'social_channel.url' => 'Đường dẫn mạng xã hội không hợp lệ.',
            
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            
            'business_fields.required' => 'Vui lòng chọn ít nhất một lĩnh vực kinh doanh.',
            'business_fields.exists' => 'Lĩnh vực kinh doanh không hợp lệ.',
            
            'identity_card.required' => 'CCCD là bắt buộc.',
            'identity_card.max' => 'CCCD không được vượt quá 12 ký tự.',
            'identity_card.regex' => 'CCCD chỉ chứa số.',
            
            'identity_card_issue_date.required' => 'Ngày cấp CCCD là bắt buộc.',
            
            'home_address.required' => 'Địa chỉ nhà là bắt buộc.',
            
            'contact_phone.required' => 'Số điện thoại liên hệ là bắt buộc.',
            'contact_phone.max' => 'Số điện thoại liên hệ không được vượt quá 10 chữ số.',
            'contact_phone.regex' => 'Số điện thoại liên hệ chỉ chứa số.',
            
            'representative_email.required' => 'Email của người đại diện là bắt buộc.',
            
            'business_license_file.required' => 'File giấy phép kinh doanh là bắt buộc.',
            'identity_card_front_file.required' => 'File mặt trước chứng minh thư là bắt buộc.',
            'identity_card_back_file.required' => 'File mặt sau chứng minh thư là bắt buộc.',
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
        
        $businesMember = new BusinessMember();
        $businesMember->fill($request->only([
            'business_name',
            'business_license_number',
            'license_issue_date',
            'license_issue_place',
            'business_field',
            'head_office_address',
            'phone',
            'fax',
            'email',
            'branch_address',
            'organization_participation',
            'representative_full_name',
            'representative_position',
            'gender',
            'identity_card',
            'identity_card_issue_date',
            'home_address',
            'contact_phone',
            'representative_email',
        ]));
    
        try {
            DB::beginTransaction(); 
            $this->handleFileUpload($request, 'business_license_file', $data, '_business_license_file_', 'business_license_file');
            $this->handleFileUpload($request, 'identity_card_front_file', $data, '_identity_card_front_file_', 'CCCD');
            $this->handleFileUpload($request, 'identity_card_back_file', $data, '_identity_card_back_file_', 'CCCD');
    
           
            $businesMember->business_license_file = $data['business_license_file'];
            $businesMember->identity_card_front_file = $data['identity_card_front_file'];
            $businesMember->identity_card_back_file = $data['identity_card_back_file'];
            $businesMember->save(); 
            DB::commit(); 
    
            return redirect()->back()->with('success', 'Đăng ký thành công!');
        } catch (\Exception $e) {
            DB::rollBack(); 
            $this->cleanupUploadedFiles( $data); 
            return redirect()->back()->with('error', 'Đăng ký thất bại!')->withInput();
        }
    }
    private function handleFileUpload(Request $request, $inputName, &$data, $suffix = '', $folderType = 'business')
    {
        if ($request->hasFile($inputName)) {
            $files = is_array($request->file($inputName)) ? $request->file($inputName) : [$request->file($inputName)];
            $uploadedFiles = [];
            $folderName = date('Y/m');

            foreach ($files as $file) {
                if ($file->isValid()) {
                    $filePath = $this->moveFile($file, $folderName, $suffix, $folderType);
                    $uploadedFiles[] = $filePath;
                }
            }
            if (!empty($uploadedFiles)) {
                 $data[$inputName] = count($uploadedFiles) > 1 ? json_encode($uploadedFiles) : $uploadedFiles[0];
            }
        }
    }

    private function moveFile($file, $folderName, $suffix, $folderType)
    {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $originalFileName . $suffix . time() . '.' . $extension;

        $basePath = '';
        switch ($folderType) {
            case 'business_license_file':
                $basePath = 'uploads/images/cndkkd/';
                break;
            case 'CCCD':
                $basePath = 'uploads/images/cccd/';
                break;
            case 'other':
                $basePath = 'uploads/images/other/';
                break;
            default:
                throw new \Exception('Thư mục không hợp lệ.');
        }

        $file->move(public_path($basePath . $folderName), $fileName);
        return $basePath . $folderName . '/' . $fileName;
    }



    private function cleanupUploadedFiles(array $data)
    {
        foreach ($data as $filePath) {
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
        }
    }

}
