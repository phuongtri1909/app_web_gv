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
use App\Models\Email;

class BusinessController extends Controller
{

    public function index()
    {
        return view('pages.client.form-business');
    }

    public function adminIndex(Request $request)
    {
        $search = $request->input('search');

        $businesses = Business::whereNot('status', 'other')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                        ->orWhereHas('businessMember', function ($q) use ($search) {
                            $q->where('business_name', 'like', "%{$search}%")
                                ->orWhere('business_code', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.pages.client.form-business.index', compact('businesses'));
    }

    public function store(Request $request)
    {
        // Check business code 
        $business_member_id = $this->getBusinessMemberId($request);
       

        $request->validate([
            'avt_businesses' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'description' => 'nullable|string|max:4000',
        ], [
            'avt_businesses.required' => 'Ảnh đại diện doanh nghiệp là bắt buộc.',
            'avt_businesses.image' => 'Ảnh đại diện phải là hình ảnh.',
            'avt_businesses.mimes' => 'Hình ảnh đại diện phải là file dạng: jpg, jpeg, png, gif, svg, webp.',

            'description.max' => 'Mô tả không được vượt quá 4000 ký tự.',

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

        $existing_business = Business::where('business_member_id', $business_member_id)->first();

        if ($existing_business) {
            
            return redirect()->back()->with('error', 'DN/Hộ KD này đã được đăng ký, vui lòng đăng ký DN/Hộ KD khác.');
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

                    return redirect()->back()->with('error', 'Có lỗi xảy ra khi tải ảnh lên' . $e->getMessage())->withInput();
                }
            }

            $business->description = $request->description;
            $business->business_member_id = $business_member_id;
            $business->save();
            $email = Email::where('type', 'ncb')->first();
            $business->subject = 'Đăng ký kết nối giao thương';
            if($email && $email->type == 'ncb'){
                try {
                    Mail::to($email->email)->send(new BusinessMail($business));
                } catch (\Exception $e) {
                    Log::error('Email Sending Error:', [
                        'message' => $e->getMessage(),
                    ]);
                }
            }

            DB::commit();

            

            return redirect()->route('business')->with('success', 'Đăng ký thành công, vui lòng chờ duyệt!');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }

            return redirect()->back()->with('error', 'Đăng ký thất bại' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $business = Business::whereNot('status', 'other')
            ->findOrFail($id);

        return response()->json([
            'business_name' => $business->businessMember->business_name,
            'business_code' => $business->businessMember->business_code,
            'description' => $business->description,
            'avt_businesses' => $business->avt_businesses,
            'status' => $business->status
        ]);
    }

    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();

        return redirect()->route('admin.business')->with('success', 'Xóa thành công thông tin kết nối giao thương của doanh nghiệp');
    }

    public function business(Request $request)
    {
        $businessFieldSlug = $request->get('business_field', ''); 
        $page = $request->get('page', 1); 
    
        $query = Business::with('businessMember')->where('status', 'approved')->orderBy('created_at', 'asc');
    
        if ($businessFieldSlug) {
            $businessField = BusinessField::where('slug', $businessFieldSlug)->first();
    
            if ($businessField) {
                $businessMembers = BusinessMember::whereJsonContains('business_field_id', (string)$businessField->id)
                ->pluck('id');
                $query->whereIn('business_member_id', $businessMembers);
            } else {
                $query->whereRaw('0=1'); 
            }
        }
        $businesses = $query->paginate(10, ['*'], 'page', $page);
        if ($request->ajax()) {
            return response()->json([
                'businesses' => $businesses->items(),
                'next_page_url' => $businesses->nextPageUrl(),
            ]);
        }
        $business_fields = BusinessField::all();
    
        return view('pages.client.business', compact('businesses', 'business_fields'));
    }

    public function businessDetail($business_code)
    {
        $businessMember = BusinessMember::with('businessField')->where('business_code', $business_code)->where('status', 'approved')->first();
        $businessFieldIds = json_decode($businessMember->business_field_id, true);
        $businessFields = [];
        if (!empty($businessFieldIds)) {
            $businessFields = BusinessField::whereIn('id', $businessFieldIds)->get();
        }
        $businessMember->business_field_id = (count($businessFields) > 0) ? $businessFields->pluck('name')->toArray() : [];
        
        if (!$businessMember) {
            return redirect()->route('business')->with('error', 'Không tìm thấy doanh nghiệp');
        }

        if (!$businessMember->business) {
            return redirect()->route('business')->with('error', 'Doanh nghiệp chưa đăng ký kết nối giao thương');
        }

        if (!$businessMember->business || $businessMember->business->status != 'approved') {
            return redirect()->route('business')->with('error', 'Doanh nghiệp chưa được duyệt');
        }

        $business = $businessMember->business;
        $businessField =  $businessMember->business_field_id;
        return view('pages.client.detail-business', compact('business','businessField'));
    }

    public function productDetail($slug)
    {
        $product = ProductBusiness::where('slug', $slug)
            ->whereHas('businessMember', function ($query) {
                $query->where('status', 'approved');
            })->first();

        if (!$product) {
            return redirect()->route('business.products')->with('error', 'Không tìm thấy sản phẩm');
        }
        $businessFieldIds = json_decode($product->businessMember->business_field_id, true);
        $businessFields = [];
        if (!empty($businessFieldIds)) {
            $businessFields = BusinessField::whereIn('id', $businessFieldIds)->get();
        }
        $product->business_field_id = (count($businessFields) > 0) ? $businessFields->pluck('name')->toArray() : [];
        return view('pages.client.detail-product-business', compact('product'));
    }

    public function businessProducts(Request $request)
    {
        $category = $request->category ?? '';
        $page = $request->page ?? 1;

        $query = ProductBusiness::query();

        $query->where('status', 'approved');

        if ($category) {
            $category_product_business = CategoryProductBusiness::where('slug', $category)->first();

            if ($category_product_business) {
                $query->where('category_product_id', $category_product_business->id);
            }
        }

        $products = $query->whereHas('businessMember', function ($query) {
            $query->where('status','approved');
        })->orderBy('created_at')->paginate(6, ['*'], 'page', $page);

        foreach ($products as $product) {
            $product->businessMember = $product->businessMember;
        }

        if ($request->ajax()) {
            return response()->json([
                'products' => $products->items(),
                'next_page_url' => $products->nextPageUrl()
            ]);
        }

        $category_product_business = CategoryProductBusiness::get();

        return view('pages.client.business-products', compact('products', 'category_product_business'));
    }
}
