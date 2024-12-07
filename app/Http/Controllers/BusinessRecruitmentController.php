<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessMember;
use App\Models\JobApplication;
use App\Models\CategoryBusiness;
use Illuminate\Support\Facades\DB;
use App\Models\BusinessRecruitment;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;

class BusinessRecruitmentController extends Controller
{

    public function jobConnector(Request $request)
    {
        if ($request->ajax()) {
            $recruitments = BusinessRecruitment::with(['businessMember.business'])
                ->where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            $jobApplications = JobApplication::where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            return response()->json([
                'recruitments' => $recruitments,
                'jobApplications' => $jobApplications
            ]);
        }
        return view('pages.client.job-connector');
    }
    

    public function jobConnectorDetail($id)
    {
        try {
            $recruitment = BusinessRecruitment::with('businessMember.business')->find($id);
            if (!$recruitment) {
                return response()->json(['message' => 'Recruitment not found'], 404);
            }
        
            $business = $recruitment->businessMember->business ?? null;
            return response()->json([
                'avt_businesses' => $business->avt_businesses ?? null,
                'business_name' => $recruitment->businessMember->business_name ?? null,
                'business_code' => $recruitment->businessMember->business_code ?? null,
                'recruitment_title' => $recruitment->recruitment_title,
                'recruitment_content' => $recruitment->recruitment_content,
                'recruitment_images' => json_decode($recruitment->recruitment_images, true),
                'status' => $recruitment->status,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    


    //
    public function index(Request $request)
    {
        $search = $request->input('search');
        $search_member_id = $request->input('search-member-id');
        $businessRecruitments = BusinessRecruitment::with('businessMember')
            ->when($search, function ($query, $search) {
                return $query->where('recruitment_title', 'like', '%' . $search . '%')
                    ->orWhere('recruitment_content', 'like', '%' . $search . '%');
            })

            ->when($search_member_id, function ($query, $search_member_id) {
                return $query->where('business_member_id', $search_member_id);
            })

            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $business_members = BusinessMember::all();
        return view('admin.pages.client.form-recruitment.index', compact('businessRecruitments', 'business_members'));
    }

    public function destroy(BusinessRecruitment $businessRecruitment)
    {
        $businessRecruitment->delete();
        return redirect()->route('recruitment.index')->with('success', 'Recruitment deleted successfully');
    }

    public function show($id)
    {
        $businessRecruitment = BusinessRecruitment::findOrFail($id);

        $images = json_decode($businessRecruitment->recruitment_images);
        foreach ($images as &$image) {
            $image = asset($image);
        }

        // Cấu hình thông tin doanh nghiệp
        $avtBusiness = isset($businessRecruitment->businessMember->business)
            ? asset($businessRecruitment->businessMember->business->avt_businesses)
            : asset('images/business/business_default.webp');

        $response = [
            'avt_businesses' => $avtBusiness,
            'business_name' => $businessRecruitment->businessMember->business_name,
            'business_code' => $businessRecruitment->businessMember->business_code,
            'recruitment_title' => $businessRecruitment->recruitment_title,
            'recruitment_content' => $businessRecruitment->recruitment_content,
            'recruitment_images' => $images,
            'status' => $businessRecruitment->status,
        ];

        if (auth()->check() && auth()->user()->role === 'admin') {
            return response()->json($response);
        } else {
            if ($businessRecruitment->status !== 'approved') {
                return response()->json(['message' => 'Bài tuyển dụng này không tồn tại'], 403);
            }
            return response()->json($response);
        }
    }


    public function storeForm(Request $request)
    {
        // Check business code 
        $business_member_id = $this->getBusinessMemberId($request);
    
        try {
            $avatar_paths = [];
            DB::beginTransaction();

            $validated = $request->validate([
                'recruitment_title' => 'required|string|max:255',
                'recruitment_content' => 'required|string|max:4000',
                'recruitment_images' => 'required|array|max:4',
                'recruitment_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            ], [
                'recruitment_title.required' => 'Vui lòng nhập tiêu đề tuyển dụng.',
                'recruitment_title.max' => 'Tiêu đề tuyển dụng không được vượt quá 255 ký tự.',
                'recruitment_content.required' => 'Vui lòng nhập nội dung tuyển dụng.',
                'recruitment_content.max' => 'Nội dung tuyển dụng không được vượt quá 4000 ký tự.',
                'recruitment_images.required' => 'Vui lòng chọn ảnh tuyển dụng.',
                'recruitment_images.array' => 'Ảnh tuyển dụng phải là một mảng.',
                'recruitment_images.max' => 'Ảnh tuyển dụng không được vượt quá 4 ảnh.',
                'recruitment_images.*.required' => 'Vui lòng chọn ảnh tuyển dụng.',
                'recruitment_images.*.image' => 'Ảnh tuyển dụng không đúng định dạng.',
                'recruitment_images.*.mimes' => 'Ảnh tuyển dụng phải là định dạng jpeg, png, jpg, gif hoặc webp.',
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


            if ($request->hasFile('recruitment_images')) {
                foreach ($request->file('recruitment_images') as $recruitment_image) {

                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($recruitment_image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = $originalFileName . '_' . time() . '.webp';
                    $uploadPath = public_path('uploads/images/recruitment_images/' . $folderName);

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $image = Image::make($recruitment_image->getRealPath());
                    $image->encode('webp', 75);
                    $image->save($uploadPath . '/' . $fileName);

                    $avatar_path = 'uploads/images/recruitment_images/' . $folderName . '/' . $fileName;
                    $avatar_paths[] = $avatar_path;
                }
            }


            BusinessRecruitment::create([
                'business_member_id' => $business_member_id,
                'recruitment_title' => $validated['recruitment_title'],
                'recruitment_content' => $validated['recruitment_content'],
                'recruitment_images' => json_encode($avatar_paths),
            ]);

            DB::commit();
            
            return redirect()->route('job-connector')->with('success', 'Đăng ký tuyển dụng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();

            foreach ($avatar_paths as $avatar_path) {
                if (File::exists(public_path($avatar_path))) {
                    File::delete(public_path($avatar_path));
                }
            }

            return redirect()->back()
                ->with('error', 'Đăng ký tuyển dụng thất bại: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function recruitmentRegistration()
    {
        $category_business = CategoryBusiness::all();
        return view('pages.client.form-recruitment-registration', compact('category_business'));
    }
}
