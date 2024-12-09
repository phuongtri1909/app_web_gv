<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessHousehold;
use App\Imports\BusinessHouseholdImport;
use Maatwebsite\Excel\Facades\Excel;

class BusinessHouseholdController extends Controller
{

    public function clientIndex(Request $request)
    {
        $businessHouseholds = BusinessHousehold::where('status', 'active')->paginate(25);

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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(BusinessHousehold $businessHousehold)
    {
        //
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

    public function advertising()
    {

        return view('pages.client.p17.advertising-classifieds.advertising-classifieds');
    }

    public function formAdvertising()
    {
        return view('pages.client.p17.advertising-classifieds.form-advertising');
    }
}
