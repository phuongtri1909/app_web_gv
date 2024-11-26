<?php

namespace App\Http\Controllers;

use App\Mail\BusinessMail;
use App\Models\Business;
use App\Models\Locations;
use App\Models\WardGovap;
use Illuminate\Http\Request;
use App\Models\BusinessField;
use App\Models\LocationProduct;
use App\Models\ProductBusiness;
use App\Mail\BusinessRegistered;
use App\Models\BusinessFeedback;
use App\Models\CategoryBusiness;
use Illuminate\Support\Facades\DB;
use App\Models\BusinessCapitalNeed;
use App\Models\BusinessMember;
use App\Models\BusinessSupportNeed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use App\Models\SupplyDemandConnection;
use App\Models\CategoryProductBusiness;
use Illuminate\Validation\ValidationException;
use App\Models\BusinessPromotionalIntroduction;
use App\Models\BusinessStartPromotionInvestment;


class BusinessController extends Controller
{

    public function index()
    {
        $wards = WardGovap::all();
        $category_business = CategoryBusiness::all();
        $businesses = Business::all();
        $business_fields = BusinessField::orderBy('created_at', 'desc')->get();
        return view('pages.client.form-business', compact('businesses', 'wards', 'category_business', 'business_fields'));
    }

    public function adminIndex(Request $request)
    {
        $search = $request->input('search');
        $businesses = Business::whereNot('status', 'other')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('business_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('business_code', 'like', "%{$search}%");
                });
            })
            ->paginate(15);
        $wards = WardGovap::all();
        $category_business = CategoryBusiness::all();

        return view('admin.pages.client.form-business.index', compact(
            'businesses',
            'wards',
            'category_business'
        ));
    }


    public function create()
    {
        $wards = WardGovap::all();
        $business_fields = BusinessField::all();

        return view('pages.client.form-business', compact('wards', 'business_fields'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'avt_businesses' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'description' => 'nullable|string|max:2000',
        ], [
            'avt_businesses.required' => 'Ảnh đại diện doanh nghiệp là bắt buộc.',
            'avt_businesses.image' => 'Ảnh đại diện phải là hình ảnh.',
            'avt_businesses.mimes' => 'Hình ảnh đại diện phải là file dạng: jpg, jpeg, png, gif, svg, webp.',

            'description.max' => 'Mô tả không được vượt quá 2000 ký tự.',

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

        $business_code = $request->session()->get('business_code');

        if (!$business_code) {
            return redirect()->back()->with('error', 'Thao tác sai, vui lòng thực hiện lại.')->withInput();
        }

        $business_member = BusinessMember::where('business_code', $business_code)->first();
        if (!$business_member) {
            return redirect()->back()->with('error', 'Thao tác sai, vui lòng thực hiện lại.');
        }

        $business_member_id = $business_member->id;

        $existing_business = Business::where('business_member_id', $business_member_id)->first();

        if ($existing_business) {
            session()->forget('key_business_code');
            session()->forget('business_code');
            return redirect()->route('form.check.business')->with('error', 'DN/Hộ KD này đã được đăng ký, vui lòng đăng ký DN/Hộ KD khác.');
        }
    
        $business = new Business();

        DB::beginTransaction();
        try {
            if ($request->hasFile('avt_businesses')) {
                try {
                    $image = $request->file('avt_businesses');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = $originalFileName . '_' . time() . '.webp';
                    $uploadPath = public_path('uploads/images/avatar/' . $folderName);
        
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
        
                    $image = Image::make($image->getRealPath());
                    $image->resize(200, 200)->encode('webp', 75);
                    $image->save($uploadPath . '/' . $fileName);
        
                    $image_path = 'uploads/images/avatar/' . $folderName . '/' . $fileName;
        
                    $business->avt_businesses = $image_path;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
        
                    return redirect()->back()->with('error', 'Có lỗi xảy ra khi tải ảnh lên');
                }
            }

            $business->description = $request->description;
            $business->business_member_id = $business_member_id;
            $business->save();

            $business->subject = 'Đăng ký kết nối giao thương';
            try {
                Mail::to('tri2003bt@gmail.com')->send(new BusinessMail($business));
            } catch (\Exception $e) {
                Log::error('Email Sending Error:', [
                    'message' => $e->getMessage(),
                ]);
            }

            DB::commit();

            session()->forget('key_business_code');
            session()->forget('business_code');

            return redirect()->route('business')->with('success', 'Đăng ký thành công, vui lòng chờ duyệt!');
        } catch (\Exception $e) {
            DB::rollBack();

            if(isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }

            return redirect()->back()->with('error', 'Đăng ký thất bại' . $e->getMessage())->withInput();
        }
    }




    public function show($id)
    {
        $business = Business::with(['ward', 'categoryBusiness', 'field'])
            ->whereNot('status', 'other')
            ->findOrFail($id);

        return response()->json([
            'business_name' => $business->business_name,
            'business_code' => $business->business_code,
            'representative_name' => $business->representative_name,
            'birth_year' => $business->birth_year,
            'gender' => $business->gender,
            'email' => $business->email,
            'phone_number' => $business->phone_number,
            'fax_number' => $business->fax_number,
            'address' => $business->address,
            'business_address' => $business->business_address,
            'ward' => [
                'name' => $business->ward ? $business->ward->name : null
            ],
            'category_business' => [
                'name' => $business->categoryBusiness ? $business->categoryBusiness->name : null
            ],
            'business_fields' => [
                'name' => $business->field ? $business->field->name : null
            ],
            'social_channel' => $business->social_channel,
            'description' => $business->description,
            'avt_businesses' => $business->avt_businesses,
            'business_license' => $business->business_license,
            'status' => $business->status
        ]);
    }



    public function edit($id)
    {
        $business = Business::findOrFail($id);
        return view('business.edit', compact('business'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $business = Business::findOrFail($id);
        $business->update($request->all());

        return redirect()->route('business.index')->with('success', 'Business updated successfully.');
    }


    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();

        return redirect()->route('business.index')->with('success', 'Business deleted successfully.');
    }

    public function business(Request $request)
    {
        $category = $request->category ?? '';
        $page = $request->page ?? 1;

        $query = Business::where('status', 'approved')->orderBy('created_at', 'asc');

        if ($category) {
            $category_product_business = CategoryProductBusiness::where('slug', $category)->first();
            $query->where('category_id', $category_product_business->id);
        }

        $businesses = $query->paginate(10, ['*'], 'page', $page);

        foreach ($businesses as $business) {
            $business->businessMember = $business->businessMember;
        }

        if ($request->ajax()) {
            return response()->json([
                'businesses' => $businesses->items(),
                'next_page_url' => $businesses->nextPageUrl()
            ]);
        }

        $category_product_business = CategoryProductBusiness::get();

        return view('pages.client.business', compact('businesses', 'category_product_business'));
    }

    public function businessDetail($business_code)
    {
        $businessMember = BusinessMember::where('business_code', $business_code)->first();
      
        if (!$businessMember) {
            return redirect()->route('business')->with('error', 'Không tìm thấy doanh nghiệp');
        }
        
        $business = $businessMember->business;
        return view('pages.client.detail-business', compact('business'));
    }

    public function productDetail($slug)
    {
        $product = ProductBusiness::where('slug', $slug)
            ->whereHas('business', function ($query) {
                $query->where('status', 'approved');
            })->first();

        if (!$product) {
            return redirect()->route('business.products')->with('error', 'Không tìm thấy sản phẩm');
        }

        return view('pages.client.detail-product-business', compact('product'));
    }

    public function businessProducts(Request $request)
    {
        $category = $request->category ?? '';

        if ($category) {
            $category_product_business = CategoryProductBusiness::where('slug', $category)->first();

            $products = ProductBusiness::where('category_product_id', $category_product_business->id)
                ->whereHas('business', function ($query) {
                    $query->where('status', 'approved');
                })->get();
        } else {
            $products = ProductBusiness::whereHas('business', function ($query) {
                $query->where('status', 'approved');
            })->get();
        }

        $category_product_business = CategoryProductBusiness::get();

        return view('pages.client.business-products', compact('products', 'category_product_business'));
    }

    public function connectSupplyDemand()
    {
        return view('pages.client.form-connect-supply-demand');
    }
    public function storeConnectSupplyDemand(Request $request)
    {
        DB::beginTransaction();
        $data = [];

        try {
            $request->validate([
                'owner_full_name' => 'required|string|max:255',
                'birth_year' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
                'gender' => 'required|in:male,female,other',
                'residential_address' => 'required|string|max:255',
                'business_address' => 'required|string|max:255',
                'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
                'business_code' => 'required|regex:/^\d{10}(-\d{3})?$/',
                'business_name' => 'required|string|max:255',
                'business_field' => 'required|exists:business_fields,id',
                'email' => 'required|email|max:255',
                'fanpage' => 'nullable|url',
                'product_info' => 'required|string',
                'product_standard' => 'required|string',
                'product_avatar' => 'required|image',
                'product_images.*' => 'image',
                'product_images' => 'array|max:5',
                'product_price' => 'required|numeric|min:0',
                'product_price_mini_app' => 'required|numeric|min:0',
                'product_price_member' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ], [
                'owner_full_name.required' => 'Vui lòng nhập họ tên chủ doanh nghiệp.',
                'owner_full_name.max' => 'Họ tên chủ doanh nghiệp không được vượt quá 255 ký tự.',
                'birth_year.required' => 'Năm sinh là bắt buộc.',
                'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
                'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
                'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
                'birth_year.integer' => 'Năm sinh phải là số nguyên.',
                'gender.required' => 'Vui lòng chọn giới tính.',
                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'phone.max' => 'Số điện thoại không được vượt quá 10 chữ số.',
                'phone.regex' => 'Số điện thoại chỉ được phép chứa các ký tự số.',
                'residential_address.required' => 'Vui lòng nhập địa chỉ cư trú.',
                'residential_address.max' => 'Địa chỉ cư trú không được vượt quá 255 ký tự.',
                'business_address.required' => 'Vui lòng nhập địa chỉ kinh doanh.',
                'business_address.max' => 'Địa chỉ kinh doanh không được vượt quá 255 ký tự.',
                'business_name.required' => 'Vui lòng nhập tên doanh nghiệp/hộ kinh doanh.',
                'business_name.max' => 'Tên doanh nghiệp/hộ kinh doanh không được vượt quá 255 ký tự.',
                'business_field.required' => 'Vui lòng nhập lĩnh vực kinh doanh.',
                'business_field.exists' => 'Lĩnh vực kinh doanh không hợp lệ.',
                'business_code.required' => 'Vui lòng nhập mã số thuế.',
                'business_code.regex' => 'Mã số thuế phải gồm 10 chữ số hoặc 13 chữ số với định dạng 10-3.',
                'email.required' => 'Vui lòng nhập email.',
                'email.email' => 'Email không hợp lệ.',
                'fanpage.url' => 'Đường dẫn fanpage không hợp lệ.',
                'product_info.required' => 'Vui lòng nhập thông tin sản phẩm.',
                'product_standard.required' => 'Vui lòng nhập tiêu chuẩn sản phẩm.',
                'product_avatar.required' => 'Vui lòng tải hình ảnh sản phẩm.',
                'product_avatar.image' => 'File phải là hình ảnh.',
                'product_images.array' => 'Danh sách hình ảnh không hợp lệ.',
                'product_images.max' => 'Số lượng hình ảnh không được vượt quá 5.',
                'product_images.*.image' => 'File phải là hình ảnh.',
                'product_price.required' => 'Vui lòng nhập giá sản phẩm.',
                'product_price.numeric' => 'Giá sản phẩm phải là số.',
                'product_price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
                'product_price_mini_app.required' => 'Vui lòng nhập giá sản phẩm trên Mini App.',
                'product_price_mini_app.numeric' => 'Giá sản phẩm trên Mini App phải là số.',
                'product_price_mini_app.min' => 'Giá sản phẩm trên Mini App phải lớn hơn hoặc bằng 0.',
                'product_price_member.required' => 'Vui lòng nhập giá sản phẩm trên Member.',
                'product_price_member.numeric' => 'Giá sản phẩm trên Member phải là số.',
                'product_price_member.min' => 'Giá sản phẩm trên Member phải lớn hơn hoặc bằng 0.',
                'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
                'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
                'end_date.required' => 'Vui lòng nhập ngày kết thúc.',
                'end_date.date' => 'Ngày kết thúc không hợp lệ.',
                'end_date.after' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu.',
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
            $connection = new SupplyDemandConnection();
            $connection->fill($request->only([
                'owner_full_name',
                'birth_year',
                'gender',
                'residential_address',
                'business_address',
                'phone',
                'business_code',
                'business_name',
                'business_field',
                'email',
                'fanpage',
                'product_info',
                'product_standard',
                'product_price',
                'product_price_mini_app',
                'product_price_member',
                'start_date',
                'end_date'
            ]));

            $this->handleFileUpload($request, 'product_avatar', $data, '_avatar_', 'supplydemand');
            $this->handleFileUpload($request, 'product_images', $data, '_images_', 'supplydemand');

            $connection->product_avatar = $data['product_avatar'];
            $connection->product_images = $data['product_images'];
            $connection->save();

            DB::commit();
            return redirect()->back()->with('success', 'Đăng ký kết nối cung cầu thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->cleanupUploadedFiles($data);
            return redirect()->back()->withInput()->with('error', 'Gửi thất bại: ' . $e->getMessage());
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

    private function validateExistingBusiness($existingBusiness, $validatedData)
    {
        if (
            $existingBusiness->business_name !== $validatedData['business_name'] ||
            $existingBusiness->business_address !== $validatedData['business_address'] ||
            $existingBusiness->phone_number !== $validatedData['phone_number'] ||
            $existingBusiness->email !== $validatedData['email'] ||
            $existingBusiness->representative_name !== $validatedData['representative_name']
        ) {

            return redirect()->back()->with('error', 'Thông tin doanh nghiệp không khớp.')->withInput();
        }
    }

    private function checkForExistingEmail($email)
    {
        if (Business::where('email', $email)->exists()) {
            return redirect()->back()->with('error', 'Email này đã được đăng ký trong hệ thống với một doanh nghiệp khác.')->withInput();
        }
    }
}
