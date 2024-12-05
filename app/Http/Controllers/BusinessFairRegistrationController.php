<?php

namespace App\Http\Controllers;

use App\Models\BusinessFairRegistration;
use App\Models\BusinessMember;
use App\Models\CategoryNews;
use App\Models\Language;
use App\Models\News;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class BusinessFairRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = CategoryNews::where('slug', 'hoi-cho')->first();
        $blogs = [];
        if ($category) {
            $blogs = News::with('categories')
                ->whereHas('categories', function ($query) use ($category) {
                    $query->where('id', $category->id);
                })
                ->latest('published_at')
                ->paginate(15);
        }

        return view('admin.pages.client.form-fair-registration.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = CategoryNews::where('slug', 'hoi-cho')->first();
        $languages = Language::all();
        return view('admin.pages.client.form-fair-registration.create', compact('category',  'languages'));
    }

    public function store(Request $request)
    {
        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        $rules = [
            'published_at' => 'required|date|before_or_equal:expired_at',
            'expired_at' => 'required|date|after:published_at',
        ];
        $messages = [
            'published_at.required' => __('Ngày bắt đầu là bắt buộc.'),
            'published_at.date' => __('Ngày bắt đầu phải là ngày hợp lệ.'),
            'published_at.before_or_equal' => __('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày hết hạn.'),

            'expired_at.required' => __('Ngày hết hạn là bắt buộc.'),
            'expired_at.date' => __('Ngày hết hạn phải là ngày hợp lệ.'),
            'expired_at.after' => __('Ngày hết hạn phải lớn hơn ngày bắt đầu.'),
        ];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }
        $validatedData = $request->validate($rules, $messages);

        try {
            $translateTitle = [];
            $tranSlateContent = [];
            $image_path = null;

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $tranSlateContent[$locale] = $request->get("content_{$locale}");
            }

            $slug = Str::slug($translateTitle[config('app.locale')]);

            if (News::where('slug', $slug)->exists()) {
                return redirect()->back()->with('error', __('slug_exists'));
            }

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/news/' . $folderName), $fileName);
                    $image_path = 'uploads/images/news/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }
            }

            $news = new News();
            $news->user_id = Auth::id();
            $news->setTranslations('title', $translateTitle);
            $news->setTranslations('content', $tranSlateContent);
            $news->image = $image_path;
            $news->slug = $slug;
            $news->published_at = $request->input('published_at');
            $news->expired_at = $request->input('expired_at');
            $news->save();

            try {
                if ($request->filled('category_id')) {
                    $news->categories()->attach($request->input('category_id'));
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', __('create_post_error'));
            }
            // dd($news);
            return redirect()->route('fair-registrations.index')->with('success', __('create_post_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('create_post_error')])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = CategoryNews::where('slug', 'hoi-cho')->first();
        $news = News::find($id);
        if (!$news) {
            return back()->with('error', __('no_find_data'));
        }
        $languages = Language::all();

        return view('admin.pages.client.form-fair-registration.edit', compact('news', 'languages', 'category'));
    }


    public function update(Request $request, $id)
    {
        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];
        $rules = [
            'published_at' => 'required|date|before_or_equal:expired_at',
            'expired_at' => 'required|date|after:published_at',
        ];
        $messages = [
            'published_at.required' => __('Ngày bắt đầu là bắt buộc.'),
            'published_at.date' => __('Ngày bắt đầu phải là ngày hợp lệ.'),
            'published_at.before_or_equal' => __('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày hết hạn.'),

            'expired_at.required' => __('Ngày hết hạn là bắt buộc.'),
            'expired_at.date' => __('Ngày hết hạn phải là ngày hợp lệ.'),
            'expired_at.after' => __('Ngày hết hạn phải lớn hơn ngày bắt đầu.'),
        ];
        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $validatedData = $request->validate($rules, $messages);

        try {
            $news = News::findOrFail($id);

            $translateTitle = [];
            $translateContent = [];
            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateContent[$locale] = $request->get("content_{$locale}");
            }

            if ($request->hasFile('image')) {
                try {
                    if ($news->image && File::exists(public_path($news->image))) {
                        File::delete(public_path($news->image));
                    }

                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/news/' . $folderName), $fileName);
                    $news->image = 'uploads/images/news/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($news->image) && File::exists(public_path($news->image))) {
                        File::delete(public_path($news->image));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }
            }

            $news->setTranslations('title', $translateTitle);
            $news->setTranslations('content', $translateContent);
            $news->published_at = $request->input('published_at');
            $news->expired_at = $request->input('expired_at');
            try {
                if ($request->filled('category_id')) {
                    $news->categories()->sync($request->input('category_id'));
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', __('update_error'). ' ' . $e->getMessage())->withInput();
            }
            $news->save();

            return redirect()->route('fair-registrations.index')->with('success', __('update_success'));
        } catch (\Exception $e) {
            if (isset($news->image) && File::exists(public_path($news->image))) {
                File::delete(public_path($news->image));
            }
            return back()->with('error' , __('update_error') . ' ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $news = News::find($id);

        if (!$news) {
            return redirect()->route('fair-registrations.index')->with('error', __('Không tồn tại!!'));
        }
        $news->delete();

        return redirect()->route('fair-registrations.index')->with('success', __('Xóa thành công!!'));
    }

    public function businessFairRegistration(Request $request, $news_id)
    {
        // dd($news_id);
        $businessCode = session('business_code');
        if ($businessCode) {
            $business = BusinessMember::where('business_code', $businessCode)->first();

            if ($business) {
                return view('pages.client.gv.form-fair-registration', [
                    'businessName' => $business->business_name,
                    'representativeName' => $business->representative_full_name,
                    'phoneZalo' => $business->phone_zalo,
                    'news_id' => $news_id
                ]);
            }
        }
        return redirect()->route('form.check.business')->with('error', 'Không tìm thấy doanh nghiệp, vui lòng kiểm tra lại mã số thuế.');
    }

    public function storeBusinessFairRegistration(Request $request)
    {
        // dd($request->all());

        DB::beginTransaction();
        $validatedData = $request->validate([
            'business_license' => 'nullable|file|mimes:jpg,jpeg,png',
            'representative_full_name' => 'required|string|max:255',
            'birth_year' => 'required|integer|min:1500|max:' . date('Y'),
            'gender' => 'required|in:male,female,other',
            'phone_zalo' => 'required|string|max:10|regex:/^[0-9]+$/',
            'products' => 'required|string',
            'product_images.*' => 'nullable|file|mimes:jpg,jpeg,png',
            'booth_count' => 'required|in:1,2',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'is_join_stage_promotion' => 'nullable',
            'is_join_charity' => 'nullable',
        ], [
            'business_license.mimes' => 'Giấy phép kinh doanh phải là file hình ảnh (jpg, jpeg, png) hoặc PDF. Vui lòng chọn lại tệp đúng định dạng.',
            'business_license.max' => 'Tệp giấy phép kinh doanh không được vượt quá 2MB. Vui lòng tải tệp nhỏ hơn.',
            'representative_full_name.required' => 'Vui lòng nhập tên đầy đủ của đại diện. Tên phải có ít nhất một ký tự.',
            'representative_full_name.string' => 'Tên đại diện chỉ được chứa các ký tự chữ cái và khoảng trắng.',
            'representative_full_name.max' => 'Tên đại diện không được vượt quá 255 ký tự.',
            'birth_year.required' => 'Vui lòng nhập năm sinh của đại diện.',
            'birth_year.integer' => 'Năm sinh phải là một số nguyên. Vui lòng kiểm tra lại.',
            'birth_year.min' => 'Năm sinh phải từ 1500 trở lên. Vui lòng kiểm tra lại năm bạn nhập.',
            'birth_year.max' => 'Năm sinh không thể lớn hơn năm hiện tại ({{ date("Y") }}). Vui lòng nhập lại.',
            'gender.required' => 'Vui lòng chọn giới tính từ các tùy chọn có sẵn.',
            'gender.in' => 'Giới tính phải là một trong các lựa chọn: Nam, Nữ, Khác.',
            'phone_zalo.required' => 'Vui lòng nhập số điện thoại Zalo để liên hệ.',
            'phone_zalo.regex' => 'Số điện thoại không hợp lệ. Chỉ chấp nhận các ký tự số (0-9).',
            'phone_zalo.max' => 'Số điện thoại Zalo không được vượt quá 10 ký tự.',
            'products.required' => 'Vui lòng nhập mô tả sản phẩm. Nội dung không được để trống.',
            'products.string' => 'Mô tả sản phẩm chỉ chấp nhận các ký tự chữ cái và khoảng trắng.',
            'product_images.*.mimes' => 'Hình ảnh sản phẩm phải là file hình ảnh (jpg, jpeg, png).',
            'product_images.*.max' => 'Mỗi hình ảnh sản phẩm không được vượt quá 2MB.',
            'booth_count.required' => 'Vui lòng chọn số lượng gian hàng. Lựa chọn là 1 hoặc 2.',
            'booth_count.in' => 'Số gian hàng chỉ có thể là 1 hoặc 2. Vui lòng chọn lại.',
            'discount_percentage.required' => 'Vui lòng nhập tỷ lệ giảm giá cho sản phẩm.',
            'discount_percentage.numeric' => 'Tỷ lệ giảm giá phải là một số. Vui lòng nhập một giá trị hợp lệ.',
            'discount_percentage.min' => 'Tỷ lệ giảm giá không thể nhỏ hơn 0%. Vui lòng kiểm tra lại.',
            'discount_percentage.max' => 'Tỷ lệ giảm giá không thể lớn hơn 100%. Vui lòng nhập lại.',
            'is_join_stage_promotion.boolean' => 'Lựa chọn tham gia khuyến mãi sân khấu không hợp lệ. Vui lòng chọn đúng kiểu giá trị (true/false).',
            'is_join_charity.boolean' => 'Lựa chọn tham gia từ thiện không hợp lệ. Vui lòng chọn đúng kiểu giá trị (true/false).',
        ]);

        // $recaptchaResponse = $request->input('g-recaptcha-response');
        // $secretKey = env('RECAPTCHA_SECRET_KEY');
        // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => $secretKey,
        //     'response' => $recaptchaResponse,
        // ]);

        // $responseBody = json_decode($response->body());

        // if (!$responseBody->success) {
        //     return redirect()->back()->withErrors(['error' => 'Vui lòng xác nhận bạn không phải là robot.'])->withInput();
        // }

        $business_member_id = $this->getBusinessMemberId($request);
        
        // $existingRegistration = BusinessFairRegistration::where('business_member_id', $business_member_id)->first();
        // if ($existingRegistration) {
        //     session()->forget('key_business_code');
        //     session()->forget('business_code');
        //     return back()->with('error', 'Doanh nghiệp này đã đăng ký tham gia hội chợ. Không thể đăng ký lại.')->withInput();
        // }
        $news_id = $request->input('news_id');
        $existingRegistration = BusinessFairRegistration::where('business_member_id', $business_member_id)
            ->where('news_id', $news_id)
            ->first();

        if ($existingRegistration) {
            
            return back()->with('error', 'Doanh nghiệp này đã đăng ký tham gia hội chợ này. Không thể đăng ký lại.')->withInput();
        }
        $businessLicensePath = null;
        $folderName = date('Y/m');
        if ($request->hasFile('business_license')) {
            $avatar = $request->file('business_license');
            $originalFileName = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = $originalFileName . '_' . time() . '.webp';
            $uploadPath = public_path('uploads/images/fair-registration/licenses/' . $folderName);

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $image = Image::make($avatar->getRealPath());
            $image->encode('webp', 75);
            $image->save($uploadPath . '/' . $fileName);

            $businessLicensePath = 'uploads/images/fair-registration/licenses/' . $folderName . '/' . $fileName;
        }
        $productImages = [];

        $productImages = collect($request->file('product_images'))->map(function ($image) use ($folderName) {
            $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = $originalFileName . '_' . uniqid() . '.webp';
            $uploadPath = public_path('uploads/images/fair-registration/products/' . $folderName);

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $imageInstance = Image::make($image->getRealPath());
            $imageInstance->encode('webp', 75);
            $imageInstance->save($uploadPath . '/' . $fileName);

            return 'uploads/images/fair-registration/products/' . $folderName . '/' . $fileName;
        })->toArray();

        $data['product_images'] = json_encode($productImages);

        $registration = new BusinessFairRegistration();
        $registration->business_member_id = $business_member_id;
        $registration->business_license = $businessLicensePath;
        $registration->representative_full_name = $validatedData['representative_full_name'];
        $registration->birth_year = $validatedData['birth_year'];
        $registration->gender = $validatedData['gender'];
        $registration->phone_zalo = $validatedData['phone_zalo'];
        $registration->products = $validatedData['products'];
        $registration->product_images = $data['product_images'];
        $registration->booth_count = $validatedData['booth_count'];
        $registration->discount_percentage = $validatedData['discount_percentage'];
        $registration->is_join_stage_promotion = $request->has('is_join_stage_promotion') ? 1 : 0;
        $registration->is_join_charity = $request->has('is_join_charity') ? 1 : 0;
        $registration->news_id = $news_id;

        try {
            // dd($registration);
            $registration->save();

            DB::commit();
            
            return redirect()->route('business-fair-registrations', ['news_id' => $news_id])->with('success', 'Đăng ký tham gia hội chợ thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e);
            if (isset($businessLicensePath) && File::exists(public_path($businessLicensePath))) {
                File::delete(public_path($businessLicensePath));
            }
            if (!empty($data['product_images'])) {
                foreach (json_decode($data['product_images'], true) as $imagePath) {
                    if (File::exists(public_path($imagePath))) {
                        File::delete(public_path($imagePath));
                    }
                }
            }
            return back()->with('error' ,'Có lỗi xảy ra trong quá trình lưu dữ liệu.' . '-' . $e->getMessage())->withInput();
        }
    }
    public function businessFairRegistrations(Request $request)
    {
        $category = CategoryNews::where('slug', 'hoi-cho')->first();

        $businessFairRegistrations = News::whereHas('categories', function ($query) use ($category) {
            $query->where('id', $category->id);
        })
        ->where(function ($query) {
            $query->orWhere('published_at', '<=', now());
        })
        ->where(function ($query) {
            $query->orWhere('expired_at', '>=', now());
        })
        ->paginate(15);

        $noResults = $businessFairRegistrations->isEmpty();

        foreach ($businessFairRegistrations as $blog) {
            $blog->shortContent = Str::limit(strip_tags($blog->content), 1000);
        }

        return view('pages.client.form-fair-registration.fair-registration', compact('businessFairRegistrations', 'noResults', 'category'));
    }
    public function indexJoin()
    {
        $registrations = BusinessFairRegistration::with('businessMember')
            ->paginate(10);
        return view('admin.pages.client.form-fair-registration.list.index', compact('registrations'));
    }
    public function showIndexJoin($id){
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID format'], 400);
        }

        try {
            $registration = BusinessFairRegistration::with([
                'businessMember',
                'news'
            ])->findOrFail($id);
            $productImages = json_decode($registration->product_images, true);
            return response()->json([
                'id' => $registration->id,
                'business_member_id' => $registration->businessMember->business_name,
                'business_license' => $registration->business_license,
                'representative_full_name' => $registration->representative_full_name,
                'birth_year' => $registration->birth_year,
                'gender' => $registration->gender,
                'phone_zalo' => $registration->phone_zalo,
                'products' => $registration->products,
                'product_images' => $productImages,
                'booth_count' => $registration->booth_count,
                'discount_percentage' => $registration->discount_percentage,
                'is_join_stage_promotion' => $registration->is_join_stage_promotion,
                'is_join_charity' => $registration->is_join_charity,
                'status' => $registration->status,
                'news_id' => $registration->news_id,
                'created_at' => $registration->created_at,
                'updated_at' => $registration->updated_at,
                'news' => $registration->news ? $registration->news->title : null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch details'], 500);
        }
    }
    public function destroyindexJoin($id)
    {
        $news = BusinessFairRegistration::find($id);

        if (!$news) {
            return redirect()->route('business-fair-registrations.indexJoin')->with('error', __('Không tồn tại!!'));
        }
        $news->delete();

        return redirect()->route('business-fair-registrations.indexJoin')->with('success', __('Xóa thành công!!'));
    }
}
