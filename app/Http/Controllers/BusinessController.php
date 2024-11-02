<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Locations;
use App\Models\WardGovap;
use Illuminate\Http\Request;
use App\Models\BusinessField;
use App\Models\LocationProduct;
use App\Models\ProductBusiness;
use App\Models\BusinessFeedback;
use App\Models\CategoryBusiness;
use Illuminate\Support\Facades\DB;
use App\Models\BusinessCapitalNeed;
use App\Models\BusinessSupportNeed;
use App\Models\SupplyDemandConnection;
use App\Models\CategoryProductBusiness;
use App\Models\BusinessPromotionalIntroduction;
use Illuminate\Validation\ValidationException ;
use App\Models\BusinessStartPromotionInvestment;
use Illuminate\Support\Facades\Http;
use App\Mail\BusinessRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class BusinessController extends Controller
{

    public function index()
    {
        $wards = WardGovap::all();
        $category_business = CategoryBusiness::all();
        $businesses = Business::all();
        $business_fields = BusinessField::orderBy('created_at','desc')->get();
        return view('pages.client.form-business', compact('businesses','wards','category_business','business_fields'));
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
        return view('pages.client.form-business');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'avt_businesses' => 'required|image|mimes:jpeg,png,jpg,gif',
            'representative_name' => 'required|string|max:255',
            'birth_year' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
            'gender' => 'required|string|in:male,female,other',
            'phone_number' => 'required|string|max:10|regex:/^[0-9]+$/',
            'address' => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'ward_id' => 'required|integer|exists:ward_govap,id',
            'business_name' => 'required|string|max:255',
            'business_license' => 'nullable|mimes:pdf',
            'business_code' => 'required|regex:/^\d{10}(-\d{3})?$/',
            'email' => 'nullable|email|max:255|',
            'social_channel' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'business_fields' => 'required|exists:business_fields,id',
        ], [
            'avt_businesses.required' => 'Ảnh đại diện doanh nghiệp là bắt buộc.',
            'avt_businesses.image' => 'Ảnh đại diện phải là hình ảnh.',
            'avt_businesses.mimes' => 'Hình ảnh đại diện phải là file dạng: jpg, jpeg, png.',

            'representative_name.required' => 'Tên người đại diện pháp luật là bắt buộc.',
            'representative_name.string' => 'Tên người đại diện phải là một chuỗi.',
            'representative_name.max' => 'Tên người đại diện không được vượt quá 255 ký tự.',

            'birth_year.required' => 'Năm sinh là bắt buộc.',
            'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
            'birth_year.integer' => 'Năm sinh phải là số nguyên.',
            'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
            'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',

            'gender.required' => 'Giới tính là bắt buộc.',
            'gender.in' => 'Giới tính không hợp lệ.',

            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.string' => 'Số điện thoại phải là một chuỗi.',
            'phone_number.max' => 'Số điện thoại không được hơn 10 số.',
            'phone_number.regex' => 'Số điện thoại chỉ chứa số.',

            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là một chuỗi.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

            'business_address.required' => 'Địa chỉ doanh nghiệp là bắt buộc.',
            'business_address.max' => 'Địa chỉ doanh nghiệp không được vượt quá 255 ký tự.',

            'ward_id.required' => 'Vui lòng chọn phường.',
            'ward_id.integer' => 'Phường không hợp lệ.',
            'ward_id.exists' => 'Phường không tồn tại.',

            'business_name.required' => 'Tên doanh nghiệp là bắt buộc.',
            'business_name.string' => 'Tên doanh nghiệp phải là một chuỗi.',
            'business_name.max' => 'Tên doanh nghiệp không được vượt quá 255 ký tự.',

            'business_license.mimes' => 'Giấy phép kinh doanh phải là file dạng: pdf.',

            'business_code.required' => 'Mã doanh nghiệp là bắt buộc.',
            'business_code.regex' => 'Mã doanh nghiệp không được nhỏ hơn 10 hoặc vượt quá 13 số.',
            // 'business_code.unique' => 'Mã doanh nghiệp này đã tồn tại.',

            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.unique' => 'Email này đã được sử dụng.',

            'social_channel.url' => 'Đường dẫn social không hợp lệ.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',

            'business_fields.required' => 'Vui lòng chọn ít nhất một lĩnh vực kinh doanh.',
            'business_fields.exists' => 'Lĩnh vực kinh doanh không hợp lệ.',
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

        try {
            $data = $request->except(['business_license', 'avt_businesses']);

            if ($request->hasFile('avt_businesses')) {
                $image = $request->file('avt_businesses');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/business/' . $folderName), $fileName);
                $data['avt_businesses'] = 'uploads/images/business/' . $folderName . '/' . $fileName;
            }


            if ($request->hasFile('business_license')) {
                $file = $request->file('business_license');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $licenseName = $originalFileName . '_license_' . time() . '.' . $extension;
                $file->move(public_path('/uploads/images/business/' . $folderName), $licenseName);
                $data['business_license'] = 'uploads/images/business/' . $folderName . '/' . $licenseName;
            }
            $existingBusiness = Business::where('business_code', $request->business_code)
                                    ->where('email', $request->email)
                                    ->first();

            if ($existingBusiness) {
                if ($existingBusiness->status === 'other') {
                    $existingBusiness->status = 'pending';
                    $existingBusiness->fill($data);
                    $existingBusiness->save();
                    if (!empty($data['email'])) {
                        $businessData = Business::with(['categoryBusiness', 'field', 'ward'])->find($existingBusiness->id);
                        $businessData['subject'] = 'Đăng ký doanh nghiệp';
                        try {
                            Mail::to($data['email'])->send(new BusinessRegistered($businessData));
                        } catch (\Exception $e) {
                            Log::error('Email Sending Error:', [
                                'message' => $e->getMessage(),
                                'email' => $data['email'],
                                'business_id' => $existingBusiness->id
                            ]);
                        }
                    }
                    
                } else {
                    return redirect()->back()->withInput()->withErrors(['business_code' => 'Mã số thuế đã đăng ký.']);
                }
            } else {
                $business = Business::create($data);
                if (!empty($data['email'])) {
                    $businessData = Business::with(['categoryBusiness', 'field', 'ward'])->find($business->id);
                    $businessData['subject'] = 'Đăng ký doanh nghiệp';
                    
                    try {
                        Mail::to($data['email'])->send(new BusinessRegistered($businessData));
                    } catch (\Exception $e) {
                        Log::error('Email Sending Error:', [
                            'message' => $e->getMessage(),
                            'email' => $data['email'],
                            'business_id' => $business->id
                        ]);
                    }
                }
                
            }


            // Business::create($data);

            DB::commit();
            return redirect()->route('business.index')->with('success', 'Gửi thành công!!');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($filename) && file_exists(public_path( $data['business_license']))) {
                unlink(public_path( $data['business_license']));
            }

            if (isset($licenseName) && file_exists(public_path( $data['avt_businesses']))) {
                unlink(public_path( $data['avt_businesses']));
            }

            return redirect()->back()->with('error', 'Gửi thất bại: ' . $e->getMessage())->withInput();
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

        if ($category) {
            $category_product_business = CategoryProductBusiness::where('slug', $category)->first();

            $businesses = Business::where('status', 'approved')
                ->whereHas('products', function ($query) use ($category_product_business) {
                    $query->where('category_product_id', $category_product_business->id);
                })
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $businesses = Business::where('status', 'approved')
                ->orderBy('created_at', 'asc') 
                ->get();
        }
        $category_product_business = CategoryProductBusiness::get();

        return view('pages.client.business', compact('businesses', 'category_product_business'));
    }

    public function businessDetail($business_code)
    {
        $business = Business::where('business_code', $business_code)->first();

        if (!$business) {
            return redirect()->route('business')->with('error', 'Không tìm thấy doanh nghiệp');
        }

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
                'business_field' => 'required|string',
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
                'owner_full_name', 'birth_year', 'gender', 'residential_address',
                'business_address', 'phone', 'business_code', 'business_name',
                'business_field', 'email', 'fanpage', 'product_info',
                'product_standard', 'product_price', 'product_price_mini_app',
                'product_price_member', 'start_date', 'end_date'
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


    public function showFormPromotional(){
        $business_fields = BusinessField::all();
        return view('pages.client.gv.form-promotional-introduction',compact('business_fields'));
    }

    public function storeFormPromotional(Request $request)
    {
        //dd($request->all());
        //return redirect()->back()->with('success', 'Đăng ký thành công!');
        DB::beginTransaction();
        $data = [];
        try {
            $request->validate([
                'representative_name' => 'required|string|max:255',
                'birth_year' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
                'gender' => 'required|in:male,female,other',
                'phone_number' => 'required|string|max:10|regex:/^[0-9]+$/',
                'address' => 'required|string|max:255',
                'business_address' => 'required|string|max:255',
                'business_name' => 'required|string|max:255',
                'license' => 'nullable|file|mimes:pdf|max:10240',
                'business_code' => 'required|regex:/^\d{10}(-\d{3})?$/',
                'business_field' => 'required|exists:business_fields,id',
                'email' => 'nullable|email|max:255',
                'social_channel' => 'nullable|url',
                'logo' => 'required|image|max:10240|mimes:jpg,png,jpeg,gif',
                'product_image.*' => 'image|max:10240|mimes:jpg,png,jpeg,gif',
                'product_image' => 'array',
                'product_video' => 'nullable|file|mimes:mp4,mov,avi|max:20480',
                'description' => 'nullable|string',
                'name' => 'required|string|max:255',
                'address_address' => 'required|string|max:255',
                'address_latitude' => 'required|numeric|between:-90,90',
                'address_longitude' => 'required|numeric|between:-180,180',
            ], [
                'representative_name.required' => 'Vui lòng nhập họ tên chủ doanh nghiệp.',
                'birth_year.required' => 'Năm sinh là bắt buộc.',
                'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
                'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
                'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
                'gender.required' => 'Vui lòng chọn giới tính.',
                'phone_number.required' => 'Vui lòng nhập số điện thoại.',
                'phone_number.max' => 'Số điện thoại không được vượt quá 10 chữ số.',
                'phone_number.regex' => 'Số điện thoại chỉ được phép chứa các ký tự số.',
                'address.required' => 'Vui lòng nhập địa chỉ cư trú.',
                'business_address.required' => 'Vui lòng nhập địa chỉ kinh doanh.',
                'business_name.required' => 'Vui lòng nhập tên doanh nghiệp/hộ kinh doanh.',
                'business_code.required' => 'Vui lòng nhập mã số thuế.',
                'business_code.regex' => 'Mã số thuế phải gồm 10 chữ số hoặc 13 chữ số với định dạng 10-3.',
                'email.email' => 'Email không hợp lệ.',
                'social_channel.url' => 'Đường dẫn fanpage không hợp lệ.',
                'logo.required' => 'Vui lòng tải logo doanh nghiệp.',
                'logo.image' => 'Logo phải là một hình ảnh.',
                'logo.mimes' => 'Logo phải có định dạng jpg, png, jpeg, hoặc gif.',
                'logo.max' => 'Logo không được vượt quá 10MB.',
                'product_image.required' => 'Vui lòng tải lên ít nhất một hình ảnh sản phẩm.',
                'product_image.array' => 'Hình ảnh sản phẩm phải là một mảng.',
                'product_image.*.image' => 'Hình ảnh sản phẩm phải là một hình ảnh.',
                'product_image.*.mimes' => 'Hình ảnh sản phẩm phải có định dạng jpg, png, jpeg, hoặc gif.',
                'product_image.*.max' => 'Hình ảnh sản phẩm không vượt quá 10MB.',
                'product_video.file' => 'Video phải là một tệp.',
                'product_video.mimes' => 'Video phải có định dạng mp4, mov, hoặc avi.',
                'product_video.max' => 'Video không được vượt quá 20MB.',
                'business_field.required' => 'Vui lòng chọn ngành nghề kinh doanh.',
                'business_field.exists' => 'Ngành nghề kinh doanh không hợp lệ.',
                'license.required' => 'Vui lòng tải lên giấy phép kinh doanh.',
                'license.file' => 'Giấy phép kinh doanh phải là một tệp.',
                'license.mimes' => 'Giấy phép kinh doanh phải có định dạng pdf.',
                'license.max' => 'Giấy phép kinh doanh không được vượt quá 10MB.',
                'name.required' => 'Vui lòng chọn vị trí để lấy tên địa điểm.',
                'name.max' => 'Tên địa điểm không được vượt quá 255 ký tự.',
                'address_address.required' => 'Vui lòng chọn vị trí để lấy địa chỉ.',
                'address_address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
                'address_latitude.required' => 'Vui lòng chọn vị trí để lấy vĩ độ.',
                'address_latitude.numeric' => 'Vĩ độ phải là một số.',
                'address_latitude.between' => 'Vĩ độ phải nằm trong khoảng -90 đến 90.',
                'address_longitude.required' => 'Vui lòng chọn vị trí để lấy kinh độ.',
                'address_longitude.numeric' => 'Kinh độ phải là một số.',
                'address_longitude.between' => 'Kinh độ phải nằm trong khoảng -180 đến 180.',
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
            $business = Business::where('business_code', $request->business_code)->first();
            if(!$business){
                $business = new Business();
                $business->representative_name = $request->representative_name;
                $business->birth_year = $request->birth_year;
                $business->gender = $request->gender;
                $business->phone_number = $request->phone_number;
                $business->address = $request->address;
                $business->business_address = $request->business_address;
                $business->business_name = $request->business_name;

                $this->handleFileUpload($request, 'license', $data, '_license_', 'business');
                $business->business_license = $data['license'];

                $business->business_fields = $request->business_field;
                $business->business_code = $request->business_code;
                $business->email = $request->email;
                $business->social_channel = $request->social_channel;
                $business->description = $request->description;
                $business->status = 'other';
                $business->save();
            }else{
                if ($business->status === 'other') {
                    $business->representative_name = $request->representative_name;
                    $business->birth_year = $request->birth_year;
                    $business->gender = $request->gender;
                    $business->phone_number = $request->phone_number;
                    $business->address = $request->address;
                    $business->business_address = $request->business_address;
                    $business->business_name = $request->business_name;

                    $this->handleFileUpload($request, 'license', $data, '_license_', 'business');
                    $business->business_license = $data['license'];

                    $business->business_fields = $request->business_field;
                    $business->business_code = $request->business_code;
                    $business->email = $request->email;
                    $business->social_channel = $request->social_channel;
                    $business->description = $request->description;
                    $business->save();
                }
            }

            $location = new Locations();
            $location->name = $request->name;
            $location->address_address = $request->address_address;
            $location->address_latitude = $request->address_latitude;
            $location->address_longitude = $request->address_longitude;
            $location->business_id = $business->id;
            $location->business_field_id = $request->business_field;
            $location->description = $request->description;

            $this->handleFileUpload($request, 'logo', $data, '_logo_', 'business');
            $location->image = $data['logo'];
            $location->save();

            if ($request->hasFile('product_image')) {
                $images = $request->file('product_image');
                $folderName = date('Y/m');
                $uploadedImages = [];
                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $extension = $image->getClientOriginalExtension();
                        $fileName = $originalFileName . '_' . time() . '.' . $extension;
                        $image->move(public_path('/uploads/images/product_location/' . $folderName), $fileName);
                        $uploadedImages[] = 'uploads/images/product_location/' . $folderName . '/' . $fileName;

                        // Tạo đối tượng LocationProduct cho mỗi hình ảnh
                        $locationProduct = new LocationProduct();
                        $locationProduct->location_id = $location->id;
                        $locationProduct->file_path = 'uploads/images/product_location/' . $folderName . '/' . $fileName;
                        $locationProduct->media_type = 'image';
                        $locationProduct->save();
                    }
                }
                if (!empty($uploadedImages)) {
                    $data['product_image'] = count($uploadedImages) > 1 ? json_encode($uploadedImages) : $uploadedImages[0];
                }
            }

            // Xử lý video
            $this->handleFileUpload($request, 'product_video', $data, '_video_', 'business');

            if (isset($data['product_video'])) {
                $locationProduct = new LocationProduct();
                $locationProduct->location_id = $location->id;
                $locationProduct->file_path = $data['product_video'];
                $locationProduct->media_type = 'video';
                $locationProduct->save();
            }




            DB::commit();
            return redirect()->back()->with('success', 'Đăng ký địa điểm thành công!');

        } catch (\Exception $e) {
            DB::rollBack();

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
        if ($existingBusiness->business_name !== $validatedData['business_name'] ||
            $existingBusiness->business_address !== $validatedData['business_address'] ||
            $existingBusiness->phone_number !== $validatedData['phone_number'] ||
            $existingBusiness->email !== $validatedData['email'] ||
            $existingBusiness->representative_name !== $validatedData['representative_name']) {

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
