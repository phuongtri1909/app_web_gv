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
        DB::beginTransaction();
        $data = [];

       try {
        $request->validate([
            'tenDoanhNghiep' => 'required|string|max:255',
            'giayDKKD' => 'required|string|max:255',
            'ngayCap' => 'required|date',
            'noiCap' => 'required|string|max:255',
            'linhVucHoatDong' => 'required|string|max:255',
            'diaChiTruSo' => 'required|string|max:255',
            'dienThoai' => 'required|string|max:15',
            'fax' => 'nullable|string|max:15',
            'email' => 'required|email|max:255',
            'diaChiChiNhanh' => 'nullable|string|max:255',
            'thamGiaToChuc' => 'nullable|string|max:255',
            'hoVaTen' => 'required|string|max:255',
            'chucVu' => 'required|string|max:255',
            'gioiTinh' => 'required|string',
            'cmnd' => 'required|string|max:20',
            'ngayCapCmnd' => 'required|date',
            'diaChiRieng' => 'required|string|max:255',
            'dienThoaiLienHe' => 'required|string|max:15',
            'emailDaiDien' => 'required|email|max:255',
            'cndkkd' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'cccd1' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'cccd2' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'tenDoanhNghiep.required' => 'Vui lòng nhập tên doanh nghiệp.',
            'giayDKKD.required' => 'Vui lòng nhập số giấy ĐKKD.',
            'ngayCap.required' => 'Vui lòng chọn ngày cấp giấy ĐKKD.',
            'ngayCap.date' => 'Ngày cấp giấy ĐKKD phải là một ngày hợp lệ.',
            'noiCap.required' => 'Vui lòng nhập nơi cấp giấy ĐKKD.',
            'linhVucHoatDong.required' => 'Vui lòng nhập lĩnh vực hoạt động.',
            'diaChiTruSo.required' => 'Vui lòng nhập địa chỉ trụ sở chính.',
            'dienThoai.required' => 'Vui lòng nhập số điện thoại.',
            'dienThoai.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'fax.max' => 'Số fax không được vượt quá 15 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'diaChiChiNhanh.max' => 'Địa chỉ chi nhánh không được vượt quá 255 ký tự.',
            'hoVaTen.required' => 'Vui lòng nhập họ và tên.',
            'chucVu.required' => 'Vui lòng nhập chức vụ.',
            'gioiTinh.required' => 'Vui lòng chọn giới tính.',
            'gioiTinh.in' => 'Giới tính phải là Nam hoặc Nữ.',
            'cmnd.required' => 'Vui lòng nhập số CMND/CCCD.',
            'cmnd.max' => 'Số CMND/CCCD không được vượt quá 20 ký tự.',
            'ngayCapCmnd.required' => 'Vui lòng chọn ngày cấp CMND/CCCD.',
            'ngayCapCmnd.date' => 'Ngày cấp CMND/CCCD phải là một ngày hợp lệ.',
            'diaChiRieng.required' => 'Vui lòng nhập địa chỉ riêng.',
            'dienThoaiLienHe.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'dienThoaiLienHe.max' => 'Số điện thoại liên hệ không được vượt quá 15 ký tự.',
            'emailDaiDien.required' => 'Vui lòng nhập email đại diện.',
            'emailDaiDien.email' => 'Định dạng email đại diện không hợp lệ.',
            'cndkkd.required' => 'Vui lòng tải lên file giấy ĐKKD.',
            'cndkkd.mimes' => 'File giấy ĐKKD phải là một file có định dạng jpg, jpeg, png hoặc pdf.',
            'cndkkd.max' => 'File giấy ĐKKD không được vượt quá 2MB.',
            'cccd1.required' => 'Vui lòng tải lên file ảnh mặt trước CCCD.',
            'cccd1.mimes' => 'File ảnh mặt trước CCCD phải là một file có định dạng jpg, jpeg, png hoặc pdf.',
            'cccd1.max' => 'File ảnh mặt trước CCCD không được vượt quá 2MB.',
            'cccd2.required' => 'Vui lòng tải lên file ảnh mặt sau CCCD.',
            'cccd2.mimes' => 'File ảnh mặt sau CCCD phải là một file có định dạng jpg, jpeg, png hoặc pdf.',
            'cccd2.max' => 'File ảnh mặt sau CCCD không được vượt quá 2MB.',
        ]);
        
        $businesMember = new BusinessMember();
        $businesMember->fill($request->only([
            'tenDoanhNghiep',
            'giayDKKD',
            'ngayCap',
            'noiCap',
            'linhVucHoatDong',
            'diaChiTruSo',
            'dienThoai',
            'fax',
            'email',
            'diaChiChiNhanh',
            'thamGiaToChuc',
            'hoVaTen',
            'chucVu',
            'gioiTinh',
            'cmnd',
            'ngayCapCmnd',
            'diaChiRieng',
            'dienThoaiLienHe',
            'emailDaiDien',
        ]));
        $this->handleFileUpload($request, 'cndkkd', $data, '_cndkkd_', 'CNDKKD');
        $this->handleFileUpload($request, 'cccd1', $data, '_cccd1_', 'CCCD');
        $this->handleFileUpload($request, 'cccd2', $data, '_cccd2_', 'CCCD');

        $businesMember->business_license_file = $data['cndkkd'];
        $businesMember->identity_card_front_file = $data['cccd1'];
        $businesMember->identity_card_back_file = $data['cccd2'];
        $businesMember->save();

        DB::commit();


        return redirect()->back()->with('success', 'Đăng ký thành công!');

       } catch (\Throwable $e) {
        DB::rollBack();

        $this->cleanupUploadedFiles($data);

        return redirect()->back()->with('error', 'Gửi thất bại: ' . $e->getMessage());
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
                $data[$inputName] = json_encode($uploadedFiles);
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
            case 'CNDKKD':
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
