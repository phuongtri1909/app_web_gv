<?php

namespace App\Http\Controllers;

use App\Models\BlocksGovap;
use App\Models\BusinessField;
use App\Models\DistrictsGovap;
use App\Models\WardDetail;
use App\Models\WardGovap;
use Illuminate\Http\Request;
use App\Models\LocationProduct;
use Illuminate\Support\Facades\DB;
use App\Models\Locations;
use Illuminate\Support\Facades\Http;
use App\Models\Unit;
class WardDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WardDetail::with('wardGovap');

        if ($request->has('search-date') && $request->input('search-date') != '') {
            $query->whereDate('created_at', $request->input('search-date'));
        }

        $wardDetails = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.pages.p17.nba.ward_detail.index', compact('wardDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $wardDetail = WardDetail::findOrFail($id);
        $wardGovaps = WardGovap::all();

        return view('admin.pages.p17.nba.ward_detail.edit', compact('wardDetail', 'wardGovaps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'ward_govap_id' => 'required|exists:ward_govap,id',
            'area' => 'required|numeric',
            'total_households' => 'required|numeric',
        ], [
            'ward_govap_id.required' => 'Vui lòng chọn phường.',
            'ward_govap_id.exists' => 'Phường đã chọn không tồn tại.',
            'area.required' => 'Vui lòng nhập diện tích.',
            'total_households.required' => 'Vui lòng nhập tổng số hộ gia đình.',
            'area.numeric' => 'Diện tích phải là số.',
            'total_households.numeric' => 'Tổng số hộ gia đình phải là số.',
        ]);

        try {
            $wardDetail = WardDetail::findOrFail($id);
            $wardDetail->ward_govap_id = $validated['ward_govap_id'];
            $wardDetail->area = $validated['area'];
            $wardDetail->total_households = $validated['total_households'];
            $wardDetail->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi cập nhật: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('ward-detail.index')->with('success', 'Cập nhật thành công!');
    }
    public function districts($id)
    {
        $wardDetail = WardDetail::with('districts')->findOrFail($id);

        return view('admin.pages.p17.nba.districts_govap.index', compact('wardDetail'));
    }
    public function createDistrict($id)
    {
        $wardDetail = WardDetail::findOrFail($id);
        $wardDetails = WardDetail::with('wardGovap')->get();
        return view('admin.pages.p17.nba.districts_govap.ce', compact('wardDetail', 'wardDetails'));
    }

    public function storeDistrict(Request $request, $id)
    {

        $wardDetail = WardDetail::findOrFail($id);


        $this->validateDistrict($request);

        $this->createOrUpdateDistrict($request, $wardDetail);

        return redirect()
            ->route('ward-detail.districts', $wardDetail->id)
            ->with('success', 'Khu Phố được thêm thành công!');
    }

    public function editDistrict($id, $districtId)
    {
        $district = DistrictsGovap::where('id', $districtId)
            ->where('ward_detail_id', $id)
            ->firstOrFail();
        $wardDetails = WardDetail::with('wardGovap')->get();
        return view('admin.pages.p17.nba.districts_govap.ce', compact('district', 'wardDetails'));
    }

    public function updateDistrict(Request $request, $id, $districtId)
    {

        $wardDetail = WardDetail::findOrFail($id);
        $district = DistrictsGovap::where('id', $districtId)
            ->where('ward_detail_id', $wardDetail->id)
            ->firstOrFail();


        $this->validateDistrict($request);

        $this->createOrUpdateDistrict($request, $wardDetail, $district);

        return redirect()
            ->route('ward-detail.districts', $wardDetail->id)
            ->with('success', 'Khu Phố được cập nhật thành công!');
    }

    private function validateDistrict(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'total_households' => 'required|integer|min:0',
            'population' => 'required|integer|min:0',
            'secretary_name' => 'nullable|string|max:255',
            'head_name' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Tên Khu Phố là bắt buộc.',
            'name.max' => 'Tên Khu Phố không được vượt quá 255 ký tự.',
            'area.required' => 'Diện tích là bắt buộc.',
            'area.numeric' => 'Diện tích phải là một số.',
            'area.min' => 'Diện tích không được nhỏ hơn 0.',
            'total_households.required' => 'Tổng số hộ là bắt buộc.',
            'total_households.integer' => 'Tổng số hộ phải là một số nguyên.',
            'total_households.min' => 'Tổng số hộ không được nhỏ hơn 0.',
            'population.required' => 'Dân số là bắt buộc.',
            'population.integer' => 'Dân số phải là một số nguyên.',
            'population.min' => 'Dân số không được nhỏ hơn 0.',
            'secretary_name.max' => 'Tên Bí Thư không được vượt quá 255 ký tự.',
            'head_name.max' => 'Tên Trưởng Khu Phố không được vượt quá 255 ký tự.',
        ]);
    }

    private function createOrUpdateDistrict(Request $request, $wardDetail, $district = null)
    {
        $data = [
            'ward_detail_id' => $wardDetail->id,
            'name' => $request->name,
            'area' => $request->area,
            'total_households' => $request->total_households,
            'population' => $request->population,
            'secretary_name' => $request->secretary_name,
            'head_name' => $request->head_name,
        ];

        if ($district) {

            $district->update($data);
        } else {

            DistrictsGovap::create($data);
        }
    }


    public function createBlock($districtId)
    {
        $district = DistrictsGovap::findOrFail($districtId);
        $districts = DistrictsGovap::with('blocks')->get();
        return view('admin.pages.p17.nba.blocks_govap.ce', compact('district','districts'));
    }



    public function storeBlock(Request $request, $districtId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total_households' => 'required|integer|min:0',
        ], [
            'name.required' => 'Tên tổ dân phố là bắt buộc.',
            'name.max' => 'Tên tổ dân phố không được vượt quá 255 ký tự.',
            'total_households.required' => 'Tổng số hộ là bắt buộc.',
            'total_households.integer' => 'Tổng số hộ phải là một số nguyên.',
            'total_households.min' => 'Tổng số hộ không được nhỏ hơn 0.',
        ]);

        $district = DistrictsGovap::findOrFail($districtId);

        BlocksGovap::create([
            'districts_govap_id' => $district->id,
            'name' => $validated['name'],
            'total_households' => $validated['total_households'],
        ]);

        return redirect()->route('blocks', $district->id)
            ->with('success', 'Tổ dân phố được thêm thành công!');
    }



    public function blocks($id)
    {
        $district = DistrictsGovap::findOrFail($id);
        $blocksGovap = BlocksGoVap::where('districts_govap_id', $district->id)->get();

        return view('admin.pages.p17.nba.blocks_govap.index', compact('district', 'blocksGovap'));
    }


    public function editBlock($districtId, $blockId)
    {
        $district = DistrictsGovap::findOrFail($districtId);
        $block = BlocksGovap::findOrFail($blockId);
        $districts = DistrictsGovap::with('blocks')->get();
        return view('admin.pages.p17.nba.blocks_govap.ce', compact('district', 'block','districts'));
    }



    public function updateBlock(Request $request, $districtId, $blockId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total_households' => 'required|integer|min:0',
        ], [
            'name.required' => 'Tên tổ dân phố là bắt buộc.',
            'name.max' => 'Tên tổ dân phố không được vượt quá 255 ký tự.',
            'total_households.required' => 'Tổng số hộ là bắt buộc.',
            'total_households.integer' => 'Tổng số hộ phải là một số nguyên.',
            'total_households.min' => 'Tổng số hộ không được nhỏ hơn 0.',
        ]);

        $district = DistrictsGovap::findOrFail($districtId);
        $block = BlocksGovap::findOrFail($blockId);

        $block->update([
            'districts_govap_id' => $district->id,
            'name' => $validated['name'],
            'total_households' => $validated['total_households'],
        ]);

        return redirect()->route('blocks', $district->id)
            ->with('success', 'Tổ dân phố đã được cập nhật thành công!');
    }

    public function showFormLocations()
    {
        $district = DistrictsGovap::all();
        return view('admin.pages.p17.nba.ward_detail.form_locations.form-locations', compact('district'));
    }

    public function storeFormLocations(Request $request)
    {
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
                'districts_govap_id' => 'required|exists:districts_govap,id',
            ], [
                'product_image.required' => 'Vui lòng chọn ít nhất một hình ảnh.',
                'product_image.array' => 'Ảnh sản phẩm phải là một mảng.',
                'product_image.*.required' => 'Vui lòng chọn ảnh sản phẩm.',
                'product_image.*.image' => 'Ảnh sản phẩm không đúng định dạng.',
                'product_image.*.mimes' => 'Ảnh sản phẩm phải là định dạng jpg, png, jpeg, gif hoặc webp.',
                'link_video.url' => 'Link video không hợp lệ.',
                'districts_govap_id.required' => 'Vui lòng chọn khu phố.',
                'districts_govap_id.exists' => 'Khu phố không hợp lệ.',
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

            $existingLocation = Locations::where('districts_govap_id', $request->districts_govap_id)->first();
            if ($existingLocation) {
                return redirect()->back()->with('error', 'Khu phố này đã có địa điểm!')->withInput();
            }

            $businessField = BusinessField::where('slug', 'khac')->firstOrFail();
            $location = new Locations();
            $location->name = $request->name;
            $location->address_address = $request->address_address;
            $location->address_latitude = $request->address_latitude;
            $location->address_longitude = $request->address_longitude;
            $location->business_field_id = $businessField->id;
            $location->description = $request->description;
            $location->link_video = $request->link_video;
            $location->districts_govap_id = $request->districts_govap_id;
            $location->status = 'approved';

            if (request()->routeIs('form.location.store')) {
                $location->unit_id = Unit::where('unit_code','P17')->first()->id;
            }

            $location->save();

            if ($request->hasFile('product_image')) {
                $this->handleFileUpload1($request, 'product_image', $data, '_product_', 'product_image');

                if (is_string($data['product_image']) && is_array(json_decode($data['product_image'], true))) {
                    $uploadedImages = json_decode($data['product_image'], true);
                } else {
                    $uploadedImages = is_array($data['product_image']) ? $data['product_image'] : [$data['product_image']];
                }

                foreach ($uploadedImages as $filePath) {
                    $locationProduct = new LocationProduct();
                    $locationProduct->location_id = $location->id;
                    $locationProduct->file_path = $filePath;
                    $locationProduct->media_type = 'image';
                    $locationProduct->save();
                }
            }

            DB::commit();

            return redirect()->route('locations.index')->with('success', 'Thêm địa điểm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->cleanupUploadedFiles1($data);
            return redirect()->back()->with('error', 'Thêm địa điểm thất bại: ' . $e->getMessage())->withInput();
        }
    }
}
