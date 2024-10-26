<?php

namespace App\Http\Controllers;

use App\Models\BankServicesInterest;
use App\Models\CustomerInterest;
use App\Models\FinancialSupport;
use App\Models\PersonalBusinessInterest;
use Illuminate\Http\Request;
// use App\Models\CustomerInterest; // Assuming there's a CustomerInterest model

class CustomerInterestController extends Controller
{
    // Display a listing of customer interests
    public function index()
    {
        // // $customerInterests = CustomerInterest::all();
        // return view('admin.customer_interests.index', compact('customerInterests'));
    }

    // Show the form for creating a new customer interest
    public function create()
    {
        return view('admin.customer_interests.create');
    }

    // Store a newly created customer interest in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // CustomerInterest::create($request->all());

        return redirect()->route('customer_interests.index')->with('success', __('Customer interest created successfully!'));
    }

    // Show the form for editing the specified customer interest
    public function edit($id)
    {
        // // $customerInterest = CustomerInterest::findOrFail($id);
        // return view('admin.customer_interests.edit', compact('customerInterest'));
    }

    // Update the specified customer interest in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // // $customerInterest = CustomerInterest::findOrFail($id);
        // $customerInterest->update($request->all());

        return redirect()->route('customer_interests.index')->with('success', __('Customer interest updated successfully!'));
    }

    // Remove the specified customer interest from storage
    public function destroy($id)
    {
        // // $customerInterest = CustomerInterest::findOrFail($id);
        // $customerInterest->delete();

        return redirect()->route('customer_interests.index')->with('success', __('Customer interest deleted successfully!'));
    }

    public function showForm($slug = null)
    {

        if ($slug) {
            $financialSupport = FinancialSupport::where('slug',$slug);
            if ($financialSupport) {
                    return view('pages.client.gv.form-customer', compact(  'slug'));
            }
            else{
                $bank_service = BankServicesInterest::where('slug',$slug);
                if ($bank_service) {
                    return view('pages.client.gv.form-customer', compact(  'slug'));
                }
            }
            return redirect()->route('show.home.bank')->with('error', __('Dịch vụ không tồn tại!!.'));
        }
        // $bank_services = BankServicesInterest::all();
        // $business_type = PersonalBusinessInterest::all();
          return view('pages.client.gv.form-customer');
    }


    public function storeForm(Request $request)
    {
        // Debugging: Show all request data
        // dd($request->all());
    
        // Validate the request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|digits:10',
            'birth_year' => 'required|integer|min:1500|max:' . date('Y'),
            'gender' => 'required|string',
            'residence_address' => 'required|string|max:255',
            'business_address' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'business_field' => 'nullable|string|max:255',
            'tax_code' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'fanpage' => 'nullable|string|max:255',
            'support_needs' => 'nullable|string|max:255',
        ], [
            'full_name.required' => 'Tên là bắt buộc.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.digits' => 'Số điện thoại phải có 10 chữ số.',
            'birth_year.required' => 'Năm sinh là bắt buộc.',
            'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'residence_address.required' => 'Địa chỉ cư trú là bắt buộc.',
            'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
            'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
        ]);
    
        // Create a new CustomerInterest instance and populate it
        $customerInterest = new CustomerInterest();
        $customerInterest->name = $validated['full_name'];
        $customerInterest->phone_number = $validated['phone_number'];
        $customerInterest->birth_year = $validated['birth_year'];
        $customerInterest->gender = $validated['gender'];
        $customerInterest->residence_address = $validated['residence_address'];
        $customerInterest->business_address = $validated['business_address'];
        $customerInterest->company_name = $validated['company_name'];
        $customerInterest->business_field = $validated['business_field'];
        $customerInterest->tax_code = $validated['tax_code'];
        $customerInterest->email = $validated['email'];
        $customerInterest->fanpage = $validated['fanpage'];
        $customerInterest->support_needs = $validated['support_needs'];
    
        // Check if a slug is provided and assign financial support or bank service ID
        if ($request->has('slug')) {
            $slug = $request->slug; // Get the slug from the request
    
            // Check for FinancialSupport
            $financialSupport = FinancialSupport::where('slug', $slug)->first();
            if ($financialSupport) {
                $customerInterest->financial_support_id = $financialSupport->id; // Assuming you want the ID
            } else {
                // Check for BankServicesInterest
                $bankService = BankServicesInterest::where('slug', $slug)->first();
                if ($bankService) {
                    $customerInterest->bank_service_id = $bankService->id; // Assuming you want the ID
                }
            }
        }
    
        // Save the customer interest record
        $customerInterest->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Gửi thành công!');
    }
    

}

