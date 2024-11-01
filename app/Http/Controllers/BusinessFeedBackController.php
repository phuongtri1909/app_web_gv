<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException ;
class BusinessFeedBackController extends Controller
{
    public function businessOpinion()
    {
        return view('pages.client.form-business-opinion');
    }
    public function storeBusinessOpinion(Request $request)
    {
        DB::beginTransaction();
        $data = [];
        try {
            $request->validate([
                'opinion' => 'required|string|max:1000',
                'attached_images' => 'required|array',
                'attached_images.*' => 'required|image|mimes:jpg,png,jpeg,gif', 
                'suggestions' => 'nullable|string|max:1000',
                'owner_full_name' => 'required|string|max:255',
                'birth_year' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
                'gender' => 'required|in:male,female,other',
                'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
                'residential_address' => 'required|string|max:255',
                'business_name' => 'required|string|max:255',
                'business_address' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'business_license' => 'required|file|mimes:pdf', 
                'fanpage' => 'nullable|string|max:1000'
            ], [
                'opinion.required' => 'Vui lòng nhập ý kiến.',
                'opinion.max' => 'Ý kiến không được vượt quá 1000 ký tự.',
                'attached_images.required' => 'Vui lòng tải lên ít nhất một hình ảnh.',
                'attached_images.array' => 'Tệp đính kèm phải là một mảng hình ảnh hợp lệ.',
                'attached_images.*.required' => 'Mỗi hình ảnh tải lên là bắt buộc.',
                'attached_images.*.image' => 'Mỗi tệp tải lên phải là một hình ảnh.',
                'attached_images.*.mimes' => 'Hình ảnh phải có định dạng: jpg, png, jpeg hoặc gif.',
                'suggestions.max' => 'Ghi chú không quá 1000 ký tự.',
                'owner_full_name.required' => 'Vui lòng nhập họ tên chủ doanh nghiệp.',
                'owner_full_name.max' => 'Họ tên chủ doanh nghiệp không được vượt quá 255 ký tự.',
                'birth_year.required' => 'Năm sinh là bắt buộc.',
                'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
                'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
                'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
                'gender.required' => 'Vui lòng chọn giới tính.',
                'gender.in' => 'Giới tính không hợp lệ.',
                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'phone.regex' => 'Số điện thoại không hợp lệ, phải có 10 số.',
                'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',
                'residential_address.required' => 'Vui lòng nhập địa chỉ cư trú.',
                'residential_address.max' => 'Địa chỉ cư trú không được vượt quá 255 ký tự.',
                'business_name.required' => 'Vui lòng nhập tên doanh nghiệp/hộ kinh doanh.',
                'business_name.max' => 'Tên doanh nghiệp/hộ kinh doanh không được vượt quá 255 ký tự.',
                'business_address.required' => 'Vui lòng nhập địa chỉ kinh doanh.',
                'business_address.max' => 'Địa chỉ kinh doanh không được vượt quá 255 ký tự.',
                'email.email' => 'Email không hợp lệ.',
                'business_license.required' => 'Vui lòng tải lên giấy phép kinh doanh.',
                'business_license.mimes' => 'Giấy phép kinh doanh phải là file dạng pdf.',
                'fanpage.max' => 'Fanpage không được vượt quá 1000 ký tự.',
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
            $businessOpinion = new BusinessFeedback();
            $businessOpinion->fill($request->only([
                'opinion', 'suggestions', 'owner_full_name', 'birth_year', 'gender', 'phone',
                'residential_address', 'business_name', 'business_address', 'email','fanpage',
            ]));
            $this->handleFileUpload($request, 'attached_images', $data, '_attached_images_', 'feedback');
            $this->handleFileUpload($request, 'business_license', $data, '_business_license_', 'business');
            $businessOpinion->attached_images = $data['attached_images'];
            $businessOpinion->business_license = $data['business_license'];
            $businessOpinion->save();

            DB::commit();
            return redirect()->back()->with('success', 'Đăng ký thành công!');

        } catch (\Exception $e) {
            DB::rollBack();

            $this->cleanupUploadedFiles($data);

            return redirect()->back()->withInput()->with('error', 'Gửi thất bại: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $businessFeedbacks = BusinessFeedback::all();
        return view('admin.pages.client.form-feed-back.index', compact('businessFeedbacks'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        $feedback = BusinessFeedback::findOrFail($id);
        return response()->json([
            'id' => $feedback->id,
            'business_name' => $feedback->business_name,
            'owner_full_name' => $feedback->owner_full_name,
            'birth_year' => $feedback->birth_year,
            'gender' => $feedback->gender,
            'phone' => $feedback->phone,
            'email' => $feedback->email,
            'residential_address' => $feedback->residential_address,
            'business_address' => $feedback->business_address,
            'opinion' => $feedback->opinion,
            'suggestions' => $feedback->suggestions,
            'fanpage' => $feedback->fanpage,
            'attached_images' => $feedback->attached_images,
            'business_license' => $feedback->business_license,
            'created_at' => $feedback->created_at,
            'status' => $feedback->status,
        ]);
    }

    public function edit(BusinessFeedback $businessFeedback)
    {

    }

    public function update(Request $request, BusinessFeedback $businessFeedback)
    {

    }

    public function destroy(BusinessFeedback $businessFeedback)
    {
        try {
            if ($businessFeedback->business_license && file_exists(public_path($businessFeedback->business_license))) {
                unlink(public_path($businessFeedback->business_license));
            }

            if ($businessFeedback->attached_images) {
                $images = json_decode($businessFeedback->attached_images);
                foreach ($images as $image) {
                    if (file_exists(public_path($image))) {
                        unlink(public_path($image));
                    }
                }
            }

            $businessFeedback->delete();
            return redirect()->route('feedback.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại: ' . $e->getMessage());
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
            case 'feedback':
                $basePath = 'uploads/images/feedback/';
                break;
            case 'business':
                $basePath = 'uploads/images/business/';
                break;
            case 'other':
                $basePath = 'uploads/images/other/';
                break;
            case 'supplydemand':
                $basePath = 'uploads/images/supply_demand/';
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
