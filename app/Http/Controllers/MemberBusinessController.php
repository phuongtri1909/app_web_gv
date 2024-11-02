<?php

namespace App\Http\Controllers;

use App\Models\BusinessMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BusinessRegistered;

class MemberBusinessController extends Controller
{

    public function index()
    {
        $members = BusinessMember::latest()->paginate(10);
        return view('admin.pages.client.form-member.index', compact('members'));
    }
    public function showFormMemberBusiness()
    {
        return view('pages.client.gv.form-member-business');
    }
    public function storFormMemberBusiness(Request $request)
    {
        DB::beginTransaction();
        $data = [];
        // dd($request->all());
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_license_number' => 'required|string|max:25',
            'license_issue_date' => 'required|date',
            'license_issue_place' => 'required|string|max:255',
            'business_field' => 'required|string|max:255',
            'head_office_address' => 'required|string|max:255',
            'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
            'fax' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'branch_address' => 'nullable|string|max:255',
            'organization_participation' => 'nullable|string|max:255',
            'representative_full_name' => 'required|string|max:255',
            'representative_position' => 'required|string|max:255',
            'gender' => 'required|string',
            'identity_card' => 'required|string|max:12|regex:/^[0-9]+$/',
            'identity_card_issue_date' => 'required|date',
            'home_address' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:10|regex:/^[0-9]+$/',
            'representative_email' => 'required|email|max:255',
            'business_license_file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'identity_card_front_file' => 'required|image',
            'identity_card_back_file' => 'required|image',
        ], [
            'business_name.required' => 'Tên doanh nghiệp là bắt buộc.',
            'business_name.max' => 'Tên doanh nghiệp không được vượt quá 255 ký tự.',

            'business_license_number.required' => 'Số giấy phép kinh doanh là bắt buộc.',
            'business_license_number.max' => 'Số giấy phép kinh doanh không được vượt quá 25 ký tự.',

            'license_issue_date.required' => 'Ngày cấp giấy phép là bắt buộc.',
            'license_issue_date.date' => 'Ngày cấp giấy phép phải là ngày hợp lệ.',

            'license_issue_place.required' => 'Nơi cấp giấy phép là bắt buộc.',
            'license_issue_place.max' => 'Nơi cấp giấy phép không được vượt quá 255 ký tự.',

            'business_field.required' => 'Lĩnh vực kinh doanh là bắt buộc.',
            'business_field.max' => 'Lĩnh vực kinh doanh không được vượt quá 255 ký tự.',

            'head_office_address.required' => 'Địa chỉ trụ sở chính là bắt buộc.',
            'head_office_address.max' => 'Địa chỉ trụ sở chính không được vượt quá 255 ký tự.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.max' => 'Số điện thoại không được vượt quá 10 chữ số.',
            'phone.regex' => 'Số điện thoại chỉ chứa số.',

            'fax.max' => 'Số fax không được vượt quá 15 ký tự.',

            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',

            'branch_address.max' => 'Địa chỉ chi nhánh không được vượt quá 255 ký tự.',

            'organization_participation.max' => 'Tham gia tổ chức không được vượt quá 255 ký tự.',

            'representative_full_name.required' => 'Họ và tên người đại diện là bắt buộc.',
            'representative_full_name.max' => 'Họ và tên người đại diện không được vượt quá 255 ký tự.',

            'representative_position.required' => 'Chức vụ của người đại diện là bắt buộc.',
            'representative_position.max' => 'Chức vụ không được vượt quá 255 ký tự.',

            'gender.required' => 'Giới tính là bắt buộc.',

            'identity_card.required' => 'CCCD là bắt buộc.',
            'identity_card.max' => 'CCCD không được vượt quá 12 ký tự.',
            'identity_card.regex' => 'CCCD chỉ chứa số.',

            'identity_card_issue_date.required' => 'Ngày cấp CCCD là bắt buộc.',
            'identity_card_issue_date.date' => 'Ngày cấp CCCD phải là ngày hợp lệ.',

            'home_address.required' => 'Địa chỉ nhà là bắt buộc.',
            'home_address.max' => 'Địa chỉ nhà không được vượt quá 255 ký tự.',

            'contact_phone.required' => 'Số điện thoại liên hệ là bắt buộc.',
            'contact_phone.max' => 'Số điện thoại liên hệ không được vượt quá 10 chữ số.',
            'contact_phone.regex' => 'Số điện thoại liên hệ chỉ chứa số.',

            'representative_email.required' => 'Email của người đại diện là bắt buộc.',
            'representative_email.email' => 'Email của người đại diện không hợp lệ.',
            'representative_email.max' => 'Email của người đại diện không được vượt quá 255 ký tự.',

            'business_license_file.required' => 'File giấy phép kinh doanh là bắt buộc.',
            'business_license_file.mimes' => 'File giấy phép kinh doanh phải có định dạng jpg, jpeg, png, pdf, doc, hoặc docx.',

            'identity_card_front_file.required' => 'File mặt trước chứng minh thư là bắt buộc.',
            'identity_card_front_file.image' => 'File mặt trước chứng minh thư phải là một hình ảnh.',

            'identity_card_back_file.required' => 'File mặt sau chứng minh thư là bắt buộc.',
            'identity_card_back_file.image' => 'File mặt sau chứng minh thư phải là một hình ảnh.',
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
            $this->handleFileUpload($request, 'business_license_file', $data, '_business_license_file_', 'business_license_file');
            $this->handleFileUpload($request, 'identity_card_front_file', $data, '_identity_card_front_file_', 'CCCD');
            $this->handleFileUpload($request, 'identity_card_back_file', $data, '_identity_card_back_file_', 'CCCD');


            $businesMember->business_license_file = $data['business_license_file'];
            $businesMember->identity_card_front_file = $data['identity_card_front_file'];
            $businesMember->identity_card_back_file = $data['identity_card_back_file'];
            $businesMember->save();
            DB::commit();

            $businessData = BusinessMember::find($businesMember->id);
            $businessData['subject'] = 'Đăng ký gia nhập hội viên';
            if(!empty($reqest->representative_email)){
                try {
                    Mail::to($request->representative_email)->send(new BusinessRegistered($businessData));
                } catch (\Exception $e) {
                    Log::error('Email Sending Error:', [
                        'message' => $e->getMessage(),
                        'email' => $request->representative_email,
                        'business_member_id' => $businesMember->id
                    ]);
                }
            }
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
    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID format'], 400);
        }

        try {
            $member = BusinessMember::findOrFail($id);

            return response()->json([
                'id' => $member->id,
                'business_name' => $member->business_name,
                'business_license_number' => $member->business_license_number,
                'license_issue_date' => $member->license_issue_date,
                'license_issue_place' => $member->license_issue_place,
                'business_field' => $member->business_field,
                'head_office_address' => $member->head_office_address,
                'phone' => $member->phone,
                'fax' => $member->fax,
                'email' => $member->email,
                'branch_address' => $member->branch_address,
                'organization_participation' => $member->organization_participation,
                'representative_full_name' => $member->representative_full_name,
                'representative_position' => $member->representative_position,
                'representative_email' => $member->representative_email,
                'home_address' => $member->home_address,
                'contact_phone' => $member->contact_phone,  
                'gender' => $member->gender,
                'identity_card' => $member->identity_card,
                'identity_card_issue_date' => $member->identity_card_issue_date,
                'business_license_file' => $member->business_license_file,
                'identity_card_front_file' => $member->identity_card_front_file,
                'identity_card_back_file' => $member->identity_card_back_file,
                'created_at' => $member->created_at,
                'status' => $member->status,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch member details'], 500);
        }
    }


}
