<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessHousehold;
use App\Imports\BusinessHouseholdImport;
use App\Models\CategoryMarket;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(BusinessHousehold $businessHousehold)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusinessHousehold $businessHousehold)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessHousehold $businessHousehold)
    {
        //
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
