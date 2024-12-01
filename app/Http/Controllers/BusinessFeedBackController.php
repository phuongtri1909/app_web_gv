<?php

namespace App\Http\Controllers;

use App\Mail\BusinessRegistered;
use App\Models\Business;
use App\Models\BusinessFeedback;
use App\Models\BusinessMember;
use App\Models\CategoryNews;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException ;
class BusinessFeedBackController extends Controller
{
    public function businessOpinion(Request $request)
    {
        $isKhaoSat = CategoryNews::where('slug', 'khao-sat')->first();
        if (!$isKhaoSat) {
            return redirect()->back()->with('error', 'Không tìm thấy danh mục');
        }
        $business_member_id = $this->getBusinessMemberId($request);
        if ($business_member_id instanceof \Illuminate\Http\RedirectResponse) {
            return $business_member_id;
        }
        return view('pages.client.feed-back.form-business-opinion',compact('business_member_id','isKhaoSat'));
    }
    public function storeBusinessOpinion(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [];
            $business_member_id = $this->getBusinessMemberId($request);
            if ($business_member_id instanceof \Illuminate\Http\RedirectResponse) {
                return $business_member_id;
            }
            $request->validate([
                'opinion' => 'required|string|max:1000',
                'attached_images' => 'required|array',
                'attached_images.*' => 'required|image|mimes:jpg,png,jpeg,gif',
            ], [
                'opinion.required' => 'Vui lòng nhập ý kiến.',
                'opinion.max' => 'Ý kiến không được vượt quá 1000 ký tự.',
                'attached_images.required' => 'Vui lòng tải lên ít nhất một hình ảnh.',
                'attached_images.array' => 'Tệp đính kèm phải là một mảng hình ảnh hợp lệ.',
                'attached_images.*.required' => 'Mỗi hình ảnh tải lên là bắt buộc.',
                'attached_images.*.image' => 'Mỗi tệp tải lên phải là một hình ảnh.',
                'attached_images.*.mimes' => 'Hình ảnh phải có định dạng: jpg, png, jpeg hoặc gif.',
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
            $businessFeedback = new BusinessFeedback();
            $businessFeedback->fill($request->only(['opinion']));
            $businessFeedback->business_member_id = $business_member_id;
            $this->handleFileUpload($request, 'attached_images', $data, '_attached_images_', 'feedback');
            $businessFeedback->attached_images = $data['attached_images'];
            $businessFeedback->save();
            DB::commit();
            session()->forget('key_business_code');
            session()->forget('business_code');
            return redirect()->route('business.opinion')->with('success', 'Gửi thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->cleanupUploadedFiles($data);
            return redirect()->back()->withInput()->with('error', 'Gửi thất bại: ' . $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $businessFeedbacks = BusinessFeedback::with('businessMember')
            ->when($search, function ($query) use ($search) {
                return $query->where('opinion', 'like', '%' . $search . '%');
            })
            ->paginate(15);

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
        $businessMember = $feedback->businessMember;
        return response()->json([
            'id' => $feedback->id,
            'business_code' => $businessMember->business_code,
            'business_name' => $businessMember->business_name,
            'representative_full_name' => $businessMember->representative_full_name,
            'representative_phone' => $businessMember->representative_phone,
            'email' => $businessMember->email,
            'address' => $businessMember->address,
            'opinion' => $feedback->opinion,
            'attached_images' => $feedback->attached_images,
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

    public function destroy($id)
    {
        try {
            $businessFeedback = BusinessFeedback::findOrFail($id);
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
