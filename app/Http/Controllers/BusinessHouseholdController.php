<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessHousehold;
use App\Imports\BusinessHouseholdImport;
use App\Models\CategoryMarket;
use App\Models\Road;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class BusinessHouseholdController extends Controller
{

    public function clientIndex(Request $request, $slug)
    {
        $categoryMarket = CategoryMarket::where('slug', $slug)->firstOrFail();
        $businessHouseholds = $categoryMarket->businessHouseholds;
        $businessHouseholds = BusinessHousehold::where('category_market_id', $categoryMarket->id)
        ->where('status', 'active')
        ->paginate(25);

        if ($request->ajax()) {
            return view('pages.client.p17.business-household-list', compact('businessHouseholds'))->render();
        }

        return view('pages.client.p17.client-index', compact('businessHouseholds'));
    }

    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        Excel::import(new BusinessHouseholdImport, $request->file('file'));

        return redirect()->back()->with('success', 'Imported successfully');
    }

    public function clientShow($id){
        $businessHousehold = BusinessHousehold::find($id);

        return view('pages.client.p17.layouts.partials.body-modal-bhh', compact('businessHousehold'));
    }

    public function connectingSmallBusiness(){
        $categoryMarkets = CategoryMarket::all();
        return view('pages.client.p17.connecting-small-businesses', compact('categoryMarkets'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $businessHouseholds = BusinessHousehold::with(['road', 'categoryMarket'])
            ->orderBy('created_at', 'desc') 
            ->paginate(15); 

        return view('admin.pages.p17.business_household.index', compact('businessHouseholds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $roads = Road::all();
        $categoryMarkets = CategoryMarket::all();
        
        return view('admin.pages.p17.business_household.create', compact('roads', 'categoryMarkets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'license_number' => 'required|string|max:255',
            'date_issued' => 'required|date',
            'business_owner_full_name' => 'required|string|max:255',
            'business_dob' => 'required|date', 
            'house_number' => 'required|string|max:255',
            'road_id' => 'required|exists:roads,id',
            'signboard' => 'nullable|string|max:255',
            'business_field' => 'required|string',
            'phone' => 'nullable|string|max:255',
            'cccd' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'category_market_id' => 'nullable|exists:category_market,id',
        ], [
            // Custom error messages
            'license_number.required' => 'Số giấy phép là bắt buộc.',
            'license_number.string' => 'Số giấy phép phải là một chuỗi ký tự.',
            'license_number.max' => 'Số giấy phép không được vượt quá 255 ký tự.',
            'date_issued.required' => 'Ngày cấp là bắt buộc.',
            'date_issued.date' => 'Ngày cấp phải là một ngày hợp lệ.',
            'business_owner_full_name.required' => 'Tên chủ doanh nghiệp là bắt buộc.',
            'business_owner_full_name.string' => 'Tên chủ doanh nghiệp phải là một chuỗi ký tự.',
            'business_owner_full_name.max' => 'Tên chủ doanh nghiệp không được vượt quá 255 ký tự.',
            'business_dob.required' => 'Ngày sinh của chủ doanh nghiệp là bắt buộc.',
            'business_dob.date' => 'Ngày sinh của chủ doanh nghiệp phải là một ngày hợp lệ.',
            'house_number.required' => 'Số nhà là bắt buộc.',
            'house_number.string' => 'Số nhà phải là một chuỗi ký tự.',
            'house_number.max' => 'Số nhà không được vượt quá 255 ký tự.',
            'road_id.required' => 'ID đường là bắt buộc.',
            'road_id.exists' => 'ID đường đã chọn không hợp lệ.',
            'signboard.string' => 'Biển hiệu phải là một chuỗi ký tự.',
            'signboard.max' => 'Biển hiệu không được vượt quá 255 ký tự.',
            'business_field.required' => 'Lĩnh vực kinh doanh là bắt buộc.',
            'business_field.string' => 'Lĩnh vực kinh doanh phải là một chuỗi ký tự.',
            'phone.string' => 'Số điện thoại phải là một chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 255 ký tự.',
            'cccd.required' => 'Số CCCD là bắt buộc.',
            'cccd.string' => 'Số CCCD phải là một chuỗi ký tự.',
            'cccd.max' => 'Số CCCD không được vượt quá 255 ký tự.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "hoạt động" hoặc "không hoạt động".',
            'category_market_id.exists' => 'ID loại chợ đã chọn không hợp lệ.',
        ]);

        try {
        
            $businessHousehold = new BusinessHousehold();
            $businessHousehold->license_number = $validated['license_number'];
            $businessHousehold->date_issued = $validated['date_issued'];
            $businessHousehold->business_owner_full_name = $validated['business_owner_full_name'];
            $businessHousehold->business_dob = $validated['business_dob'];
            $businessHousehold->house_number = $validated['house_number'];
            $businessHousehold->road_id = $validated['road_id'];
            $businessHousehold->signboard = $validated['signboard'];
            $businessHousehold->business_field = $validated['business_field'];
            $businessHousehold->phone = $validated['phone'];
            $businessHousehold->cccd = $validated['cccd'];
            $businessHousehold->address = $validated['address'];
            $businessHousehold->status = $validated['status'];
            $businessHousehold->category_market_id = $validated['category_market_id'];
            $businessHousehold->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Lỗi khi thêm: ' . $e->getMessage())->withInput();
        }

        // Redirect back with success message
        return redirect()->route('business-households.index')->with('success', 'Thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $business = BusinessHousehold::with('road', 'categoryMarket')->findOrFail($id);

        return response()->json([
            'license_number' => $business->license_number,
            'date_issued' => $business->date_issued,
            'business_owner_full_name' => $business->business_owner_full_name,
            'business_dob' => $business->business_dob,
            'house_number' => $business->house_number,
            'road_name' => $business->road->name ?? null,
            'signboard' => $business->signboard,
            'business_field' => $business->business_field,
            'phone' => $business->phone,
            'cccd' => $business->cccd,
            'address' => $business->address,
            'status' => $business->status,
            'category_market_name' => $business->categoryMarket->name ?? null
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $businessHousehold = BusinessHousehold::findOrFail($id);
        $roads = Road::all();
        $categoryMarkets = CategoryMarket::all();
        return view('admin.pages.p17.business_household.edit', compact('businessHousehold','roads','categoryMarkets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $validated = $request->validate([
            'license_number' => 'required|string|max:255',
            'date_issued' => 'required|date',
            'business_owner_full_name' => 'required|string|max:255',
            'business_dob' => 'required|date', 
            'house_number' => 'required|string|max:255',
            'road_id' => 'required|exists:roads,id',
            'signboard' => 'nullable|string|max:255',
            'business_field' => 'required|string',
            'phone' => 'nullable|string|max:255',
            'cccd' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'category_market_id' => 'nullable|exists:category_market,id',
        ], [
            'license_number.required' => 'Số giấy phép là bắt buộc.',
            'license_number.string' => 'Số giấy phép phải là một chuỗi ký tự.',
            'license_number.max' => 'Số giấy phép không được vượt quá 255 ký tự.',
            'date_issued.required' => 'Ngày cấp là bắt buộc.',
            'date_issued.date' => 'Ngày cấp phải là một ngày hợp lệ.',
            'business_owner_full_name.required' => 'Tên chủ doanh nghiệp là bắt buộc.',
            'business_owner_full_name.string' => 'Tên chủ doanh nghiệp phải là một chuỗi ký tự.',
            'business_owner_full_name.max' => 'Tên chủ doanh nghiệp không được vượt quá 255 ký tự.',
            'business_dob.required' => 'Ngày sinh của chủ doanh nghiệp là bắt buộc.',
            'business_dob.date' => 'Ngày sinh của chủ doanh nghiệp phải là một ngày hợp lệ.',
            'house_number.required' => 'Số nhà là bắt buộc.',
            'house_number.string' => 'Số nhà phải là một chuỗi ký tự.',
            'house_number.max' => 'Số nhà không được vượt quá 255 ký tự.',
            'road_id.required' => 'ID đường là bắt buộc.',
            'road_id.exists' => 'ID đường đã chọn không hợp lệ.',
            'signboard.string' => 'Biển hiệu phải là một chuỗi ký tự.',
            'signboard.max' => 'Biển hiệu không được vượt quá 255 ký tự.',
            'business_field.required' => 'Lĩnh vực kinh doanh là bắt buộc.',
            'business_field.string' => 'Lĩnh vực kinh doanh phải là một chuỗi ký tự.',
            'phone.string' => 'Số điện thoại phải là một chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 255 ký tự.',
            'cccd.required' => 'Số CCCD là bắt buộc.',
            'cccd.string' => 'Số CCCD phải là một chuỗi ký tự.',
            'cccd.max' => 'Số CCCD không được vượt quá 255 ký tự.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "hoạt động" hoặc "không hoạt động".',
            'category_market_id.exists' => 'ID loại chợ đã chọn không hợp lệ.',
        ]);

        try {
            $businessHousehold = BusinessHousehold::findOrFail($id);
            $businessHousehold->license_number = $validated['license_number'];
            $businessHousehold->date_issued = $validated['date_issued'];
            $businessHousehold->business_owner_full_name = $validated['business_owner_full_name'];
            $businessHousehold->business_dob = $validated['business_dob'];
            $businessHousehold->house_number = $validated['house_number'];
            $businessHousehold->road_id = $validated['road_id'];
            $businessHousehold->signboard = $validated['signboard'];
            $businessHousehold->business_field = $validated['business_field'];
            $businessHousehold->phone = $validated['phone'];
            $businessHousehold->cccd = $validated['cccd'];
            $businessHousehold->address = $validated['address'];
            $businessHousehold->status = $validated['status'];
            $businessHousehold->category_market_id = $validated['category_market_id'];
            $businessHousehold->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Lỗi cập nhật ' . $e->getMessage())->withInput();
        }

        // Redirect to the business households index page with success message
        return redirect()->route('business-households.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $businessHousehold = BusinessHousehold::findOrFail($id);
            $businessHousehold->delete();
            
            return redirect()->route('business-households.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            Log::error('Error deleting business household: ' . $e->getMessage());
            return redirect()->route('business-households.index')->with('error', 'Lỗi khi xóa: ' . $e->getMessage());
        }
    }
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_id' => 'required|exists:business_households,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $business = BusinessHousehold::find($request->business_id);

        if (!$business) {
            return response()->json(['error' => 'Tiểu thương này không tồn tại']);
        }

        $business->status = $request->status;
        $business->save();

        return response()->json(['success' => 'Thay đổi trạng thái thành công']);
    }
}
