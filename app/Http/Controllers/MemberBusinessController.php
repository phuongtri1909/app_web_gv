<?php

namespace App\Http\Controllers;

use App\Models\BusinessMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MemberBusinessController extends Controller
{
    //
    public function showFormMemberBusiness()
    {
        return view('pages.client.gv.form-member-business');
    }
    public function storFormMemberBusiness(Request $request)
    {
        $data = [];

        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_license_number' => 'required|string|max:25',
            'license_issue_date' => 'required|date',
            'license_issue_place' => 'required|string|max:255',
            'business_field' => 'required|string|max:255',
            'head_office_address' => 'required|string|max:255',
            'phone' =>  'required|string|max:10|regex:/^[0-9]+$/',
            'fax' => 'nullable|string|max:15',
            'email' => 'required|email|max:255',
            'branch_address' => 'nullable|string|max:255',
            'organization_participation' => 'nullable|string|max:255',
            'representative_full_name' => 'required|string|max:255',
            'representative_position' => 'required|string|max:255',
            'gender' => 'required|string',
            'identity_card' =>  'required|string|max:12|regex:/^[0-9]+$/',
            'identity_card_issue_date' => 'required|date',
            'home_address' => 'required|string|max:255',
            'contact_phone' =>  'required|string|max:10|regex:/^[0-9]+$/',
            'representative_email' => 'required|email|max:255',
            'business_license_file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'identity_card_front_file' => 'required|image|max:2048',
            'identity_card_back_file' => 'required|image|max:2048',
        ], [
            'business_name.required' => 'Vui lòng nhập tên doanh nghiệp.',
            'business_license_number.required' => 'Vui lòng nhập số giấy ĐKKD.',
            'business_license_number.max' => 'ĐKKD phải có đúng 25 ký tự.',
            'license_issue_date.required' => 'Vui lòng chọn ngày cấp giấy ĐKKD.',
            'license_issue_date.date' => 'Ngày cấp giấy ĐKKD phải là một ngày hợp lệ.',
            'license_issue_place.required' => 'Vui lòng nhập nơi cấp giấy ĐKKD.',
            'business_field.required' => 'Vui lòng nhập lĩnh vực hoạt động.',
            'head_office_address.required' => 'Vui lòng nhập địa chỉ trụ sở chính.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ,số điện thoại phải có 10 số',
            'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',
            'fax.max' => 'Số fax không được vượt quá 15 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'branch_address.max' => 'Địa chỉ chi nhánh không được vượt quá 255 ký tự.',
            'representative_full_name.required' => 'Vui lòng nhập họ và tên.',
            'representative_position.required' => 'Vui lòng nhập chức vụ.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.in' => 'Giới tính phải là Nam hoặc Nữ.',
            'identity_card.required' => 'Vui lòng nhập số identity_card/CCCD.',
            'identity_card_issue_date.required' => 'Vui lòng chọn ngày cấp identity_card/CCCD.',
            'identity_card_issue_date.date' => 'Ngày cấp identity_card/CCCD phải là một ngày hợp lệ.',
            'home_address.required' => 'Vui lòng nhập địa chỉ riêng.',
            'contact_phone.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'contact_phone.max' => 'Số điện thoại liên hệ không được vượt quá 11 số.',
            'contact_phone.regex' => 'Số điện thoại liên hệ phải có 10 số',
            'representative_email.required' => 'Vui lòng nhập email đại diện.',
            'representative_email.email' => 'Định dạng email đại diện không hợp lệ.',
            'business_license_file.required' => 'Vui lòng tải lên file giấy ĐKKD.',
            'business_license_file.mimes' => 'File giấy ĐKKD phải là một file có định dạng jpg, jpeg, png hoặc pdf.',
            'business_license_file.max' => 'File giấy ĐKKD không được vượt quá 2MB.',
            'identity_card_front_file.required' => 'Vui lòng tải lên file ảnh mặt trước CCCD.',
            'identity_card_front_file.image' => 'File ảnh mặt trước CCCD phải là định dạng ảnh.',
            'identity_card_front_file.mimes' => 'File ảnh mặt trước CCCD phải là một file có định dạng jpg, jpeg hoặc png.',
            'identity_card_front_file.max' => 'File ảnh mặt trước CCCD không được vượt quá 2MB.',
        
            'identity_card_back_file.required' => 'Vui lòng tải lên file ảnh mặt sau CCCD.',
            'identity_card_back_file.image' => 'File ảnh mặt sau CCCD phải là định dạng ảnh.',
            'identity_card_back_file.mimes' => 'File ảnh mặt sau CCCD phải là một file có định dạng jpg, jpeg hoặc png.',
            'identity_card_back_file.max' => 'File ảnh mặt sau CCCD không được vượt quá 2MB.',
        ]);
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
            return redirect()->back()->with('error', 'Đăng ký thất bại!');
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
