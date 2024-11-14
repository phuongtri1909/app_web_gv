<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Locations;
use Illuminate\Http\Request;
use App\Models\BusinessField;
use App\Models\LocationProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{

    public function clientIndex()
    {
        $locations = Locations::where('status', 'accepted')->with('businessField')->with('locationProducts')->paginate(15);
        $business_fields = BusinessField::all();
        return view('pages.client.locations', compact('locations', 'business_fields'));
    }

    public function getAllLocations()
    {
        $locations = Locations::with('businessField')->where('status', 'accepted')->get();
        return response()->json($locations);
    }

    public function searchLocations(Request $request)
    {
        $query = $request->input('query');
        $businessField = $request->input('business_field');

        $locations = Locations::where('status', 'accepted');

        if ($query) {
            $locations->where('name', 'like', '%' . $query . '%')
                ->orWhere('address_address', 'like', '%' . $query . '%');
        }

        if ($businessField) {
            $locations->where('business_field_id', $businessField);
        }

        $locations->with('businessField');

        $results = $locations->get();

        return response()->json($results);
    }

    public function showFormPromotional()
    {
        $business_fields = BusinessField::all();
        return view('pages.client.gv.form-promotional-introduction', compact('business_fields'));
    }

    public function storeFormPromotional(Request $request)
    {
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
                'logo' => 'required|image|max:10240|mimes:jpg,png,jpeg,gif,webp,svg',
                'product_image.*' => 'image|max:10240|mimes:jpg,png,jpeg,gif,webp,svg',
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
                'logo.mimes' => 'Logo phải có định dạng jpg, png, jpeg,webp,svg hoặc gif.',
                'logo.max' => 'Logo không được vượt quá 10MB.',
                'product_image.required' => 'Vui lòng tải lên ít nhất một hình ảnh sản phẩm.',
                'product_image.array' => 'Hình ảnh sản phẩm phải là một mảng.',
                'product_image.*.image' => 'Hình ảnh sản phẩm phải là một hình ảnh.',
                'product_image.*.mimes' => 'Hình ảnh sản phẩm phải có định dạng jpg, png, jpeg,webp,svg hoặc gif.',
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
            if (!$business) {
                $business = new Business();
                $business->representative_name = $request->representative_name;
                $business->birth_year = $request->birth_year;
                $business->gender = $request->gender;
                $business->phone_number = $request->phone_number;
                $business->address = $request->address;
                $business->business_address = $request->business_address;
                $business->business_name = $request->business_name;

                $this->handleDocumentUpload1($request, 'license', $data, '_license_', 'business');
                $business->business_license = $data['license'];

                $business->business_fields = $request->business_field;
                $business->business_code = $request->business_code;
                $business->email = $request->email;
                $business->social_channel = $request->social_channel;
                $business->description = $request->description;
                $business->status = 'other';
                $business->save();
            } else {
                if ($business->status === 'other') {
                    $business->representative_name = $request->representative_name;
                    $business->birth_year = $request->birth_year;
                    $business->gender = $request->gender;
                    $business->phone_number = $request->phone_number;
                    $business->address = $request->address;
                    $business->business_address = $request->business_address;
                    $business->business_name = $request->business_name;

                    $this->handleDocumentUpload1($request, 'license', $data, '_license_', 'business');
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

            $this->handleFileUpload1($request, 'logo', $data, '_logo_', 'logo_location');
            $location->image = $data['logo'];
            $location->save();

            if ($request->hasFile('product_image')) {


                $this->handleFileUpload1($request, 'product_image', $data, '_product_', 'product_image');
                //dd($data['product_image']);
               // Kiểm tra nếu $data['product_image'] là một chuỗi JSON hợp lệ
                if (is_string($data['product_image']) && is_array(json_decode($data['product_image'], true))) {
                    $uploadedImages = json_decode($data['product_image'], true);
                } else {
                    $uploadedImages = is_array($data['product_image']) ? $data['product_image'] : [$data['product_image']];
                }
            
                // Tạo đối tượng LocationProduct cho mỗi hình ảnh
                foreach ($uploadedImages as $filePath) {
                    $locationProduct = new LocationProduct();
                    $locationProduct->location_id = $location->id;
                    $locationProduct->file_path = $filePath;
                    $locationProduct->media_type = 'image';
                    $locationProduct->save();
                }

            }



            // Xử lý video
            if ($request->hasFile('product_video')) {
                $this->handleFileUpload1($request, 'product_video', $data, '_video_', 'product_video');
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
            $this->cleanupUploadedFiles1($data);
            return redirect()->back()->withInput()->with('error', 'Gửi thất bại: ' . $e->getMessage());
        }
    }
}
