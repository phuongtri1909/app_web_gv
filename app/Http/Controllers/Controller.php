<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function handleFileUpload1(Request $request, $inputName, &$data, $suffix = '', $folderType = 'business')
    {
        if ($request->hasFile($inputName)) {
            $files = is_array($request->file($inputName)) ? $request->file($inputName) : [$request->file($inputName)];
            $uploadedFiles = [];
            $folderName = date('Y/m');

            foreach ($files as $file) {
                if ($file->isValid()) {
                    $filePath = $this->moveFile1($file, $folderName, $suffix, $folderType);
                    $uploadedFiles[] = $filePath;
                }
            }

            if (!empty($uploadedFiles)) {
                $data[$inputName] = json_encode($uploadedFiles);
            }
        }
    }

    protected function handleDocumentUpload1(Request $request, $inputName, &$data, $suffix = '', $folderType = 'documents')
    {
        if ($request->hasFile($inputName)) {
            $files = is_array($request->file($inputName)) ? $request->file($inputName) : [$request->file($inputName)];
            $uploadedFiles = [];
            $folderName = date('Y/m');

            foreach ($files as $file) {
                if ($file->isValid()) {
                    $mimeType = $file->getMimeType();
                    if (in_array($mimeType, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain'])) {
                        $filePath = $this->moveFile1($file, $folderName, $suffix, $folderType);
                        $uploadedFiles[] = $filePath;
                    } else {
                        return back()->withErrors([$inputName => 'Unsupported file type. Only PDF, DOC, DOCX, XLS, XLSX, and TXT files are allowed.']);
                    }
                }
            }
            if (!empty($uploadedFiles)) {
                $data[$inputName] = count($uploadedFiles) > 1 ? json_encode($uploadedFiles) : $uploadedFiles[0];
            }
        }
    }

    protected function moveFile1($file, $folderName, $suffix, $folderType)
    {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $originalFileName . $suffix . time() . '.' . $extension;

        $basePath = $this->getBasePath($folderType);
        $uploadPath = public_path($basePath . $folderName);

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Kiểm tra loại tệp
        $mimeType = $file->getMimeType();
        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'])) {
            // Xử lý tệp hình ảnh
            $image = Image::make($file->getRealPath());
            $image->encode('webp', 75);
            $image->save($uploadPath . '/' . $fileName);
        } else {
            // Xử lý tệp tài liệu
            $file->move($uploadPath, $fileName);
        }

        return $basePath . $folderName . '/' . $fileName;
    }

    protected function getBasePath($folderType)
    {
        $basePaths = [
            'feedback' => 'uploads/images/feedback/',
            'business' => 'uploads/images/business/',
            'other' => 'uploads/images/other/',
            'supplydemand' => 'uploads/images/supply_demand/',
            'logo_location' => 'uploads/images/logo_location/',
            'product_video' => 'uploads/videos/product_location/',
            'product_image' => 'uploads/images/product_location/',
            'business_license_file' => 'uploads/images/cndkkd/',
            'CCCD' => 'uploads/images/cccd/',
            'product_location' => 'uploads/images/product_location/',
            'documents' => 'uploads/documents/',
        ];

        if (!array_key_exists($folderType, $basePaths)) {
            throw new \Exception('Thư mục không hợp lệ.');
        }

        return $basePaths[$folderType];
    }

    protected function cleanupUploadedFiles1(array $data)
    {
        foreach ($data as $filePath) {
            $fullPath = public_path($filePath);
            if (file_exists($fullPath) && !str_contains($fullPath, public_path('images'))) {
                unlink($fullPath);
            }
        }
    }
}
