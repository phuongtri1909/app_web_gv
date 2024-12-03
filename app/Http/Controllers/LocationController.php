<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Business;
use App\Models\Locations;
use Illuminate\Http\Request;
use App\Models\BusinessField;
use App\Models\BusinessMember;
use App\Models\LocationProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchBusinessField = $request->input('search-category');
        $searchBusinessMember = $request->input('search-member-id');

        $locations = Locations::with('businessField')->with('locationProducts');

        if ($search) {
            $locations->where('name', 'like', '%' . $search . '%')
                ->orWhere('address_address', 'like', '%' . $search . '%');
        }

        if ($searchBusinessField) {
            $locations->where('business_field_id', $searchBusinessField);
        }

        if ($searchBusinessMember) {
            $locations->where('business_member_id', $searchBusinessMember);
        }

        $unit_id = auth()->user()->unit_id;
       

        $locations = $locations->where('unit_id',$unit_id)->orderBy('created_at','desc')->paginate(15);

        $business_fields = BusinessField::all();
        $business_members = BusinessMember::all();
        return view('admin.pages.client.form-locations.index', compact('locations', 'business_fields', 'business_members'));
    }

    public function show($id)
    {
        $location = Locations::with('businessField')->with('locationProducts')->find($id);
        if (!$location) {
            return redirect()->route('locations')->with('error', 'Không tìm thấy địa điểm');
        }

        $location->businessMember = $location->businessMember;
        $location->businessField = $location->businessField;
        $location->locationProducts = $location->locationProducts;

       // dd($location);

        return view('admin.pages.client.form-locations.show', compact('location'));
    }

    public function destroy($id){
        $location = Locations::find($id);

        if (!$location) {
            return redirect()->route('locations.index')->with('error', 'Không tìm thấy địa điểm');
        };

        $location->delete();

        return redirect()->route('locations.index')->with('success', 'Xóa địa điểm thành công');

    }

    public function clientIndex()
    {
        if (request()->routeIs('locations')) {
            $unit_id = Unit::where('unit_code','QGV')->first()->id;
        }
        elseif(request()->routeIs('locations-17')){
            $unit_id = Unit::where('unit_code','P17')->first()->id;
        }
        
        $locations = Locations::where('status', 'approved')->where('unit_id',$unit_id)->with('businessField')->with('locationProducts')->with('businessField')->paginate(15);
        
        $locations->each(function ($location) {
            if ($location->businessMember) {
                $location->businessMember->business = $location->businessMember->business ?? null;
            }
        });
        
        $business_fields = BusinessField::all();
        return view('pages.client.locations', compact('locations', 'business_fields'));
    }

    public function getAllLocations(Request $request)
    {
        $routeName = $request->input('route_name');

        if ($routeName === 'locations') {
            $unit_id = Unit::where('unit_code', 'QGV')->first()->id;
        } elseif ($routeName === 'locations-17') {
            $unit_id = Unit::where('unit_code', 'P17')->first()->id;   
        }

        if ($unit_id) {
            $locations = Locations::with('businessField')->where('status', 'approved')->where('unit_id', $unit_id)->get();
        }else{
            $locations = Locations::with('businessField')->where('status', 'approved')->get();
        }

        return response()->json($locations);
    }

    public function searchLocations(Request $request)
    {
        $query = $request->input('query');
        $businessField = $request->input('business_field');
        $routeName = $request->input('route_name');

        if ($routeName === 'locations') {
            $unit_id = Unit::where('unit_code', 'QGV')->first()->id;
        } elseif ($routeName === 'locations-17') {
            $unit_id = Unit::where('unit_code', 'P17')->first()->id;   
        }


        $locations = Locations::where('status', 'approved');

        if ($query) {
            $locations->where('name', 'like', '%' . $query . '%')
                ->orWhere('address_address', 'like', '%' . $query . '%');
        }

        if ($businessField) {
            $locations->where('business_field_id', $businessField);
        }

        $locations->with('businessField');

        if ($unit_id) {
            $results = $locations->where('unit_id',$unit_id)->get();
        }else{
            $results = $locations->get();
        }

        return response()->json($results);
    }

    public function showFormPromotional()
    {
        $business_fields = BusinessField::all();
        return view('pages.client.gv.form-promotional-introduction', compact('business_fields'));
    }

    public function storeFormPromotional(Request $request)
    {
        // Check business code 
        $business_member_id = $this->getBusinessMemberId($request);
        if ($business_member_id instanceof \Illuminate\Http\RedirectResponse) {
            return $business_member_id;
        }
        DB::beginTransaction();
        $data = [];
        try {
            $request->validate([
                'product_image' => 'required|array',
                'product_image.*' => 'required|image|mimes:jpg,png,jpeg,gif,webp',
                'link_video' => 'nullable|url',
                'description' => 'required|string',
                'name' => 'required|string|max:255',
                'address_address' => 'required|string|max:255',
                'address_latitude' => 'required|numeric|between:-90,90',
                'address_longitude' => 'required|numeric|between:-180,180',
                'business_field_id' => 'required|exists:business_fields,id',
            ], [
                'product_image.required' => 'Vui lòng chọn ít nhất một hình ảnh.',
                'product_image.array' => 'Ảnh sản phẩm phải là một mảng.',
                'product_image.*.required' => 'Vui lòng chọn ảnh sản phẩm.',
                'product_image.*.image' => 'Ảnh sản phẩm không đúng định dạng.',
                'product_image.*.mimes' => 'Ảnh sản phẩm phải là định dạng jpg, png, jpeg, gif hoặc webp.',
                'link_video.url' => 'Link video không hợp lệ.',
                'business_field_id.required' => 'Vui lòng chọn lĩnh vực kinh doanh.',
                'business_field_id.exists' => 'Lĩnh vực kinh doanh không hợp lệ.',
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
                'description.required' => 'Vui lòng nhập thông tin điểm đến.',
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

            $location = new Locations();
            $location->name = $request->name;
            $location->address_address = $request->address_address;
            $location->address_latitude = $request->address_latitude;
            $location->address_longitude = $request->address_longitude;
            $location->business_member_id = $business_member_id;
            $location->business_field_id = $request->business_field_id;
            $location->description = $request->description;
            $location->link_video = $request->link_video;

            if (request()->routeIs('form.promotional.store')) {
                $location->unit_id = Unit::where('unit_code','QGV')->first()->id;
            }

            $location->save();


            if ($request->hasFile('product_image')) {


                $this->handleFileUpload1($request, 'product_image', $data, '_product_', 'product_image');
                
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

            DB::commit();
            session()->forget('key_business_code');
            session()->forget('business_code');
            return redirect()->route('locations')->with('success', 'Đăng ký địa điểm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->cleanupUploadedFiles1($data);
            return redirect()->back()->with('error', 'Đăng ký địa điểm thất bại' . $e->getMessage())->withInput();
        }
    }
}
