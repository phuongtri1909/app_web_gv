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

    public function showForm($financialSupportId = null)
    {

        if ($financialSupportId) {
            $financialSupport = FinancialSupport::find($financialSupportId);

            if (!$financialSupport) {
                return redirect()->route('show.home.bank')
                    ->with('error', __('ID hỗ trợ tài chính không hợp lệ.'));
            }
        } else {
            $financialSupport = null;
        }

        $bank_services = BankServicesInterest::all();
        $business_type = PersonalBusinessInterest::all();

        return view('pages.client.gv.form-customer', compact('financialSupportId', 'bank_services', 'business_type', 'financialSupport'));
    }


    public function storeForm(Request $request, $financialSupportId = null)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|digits:10',
            'birth_year' => 'required|digits:4|min:1500|max:' . date('Y'),
            'gender' => 'required|string',
            'residence_address' => 'required|string|max:255',
            'business_address' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'business_field' => 'nullable|string|max:255',
            'tax_code' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'fanpage' => 'nullable|string|max:255',
            'support_needs' => 'nullable|string|max:255',
            'financial_support_id' => 'nullable|exists:financial_support,id',
        ], [
            'full_name.required' => 'Tên là bắt buộc.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.digits' => 'Số điện thoại phải có 10 chữ số.',
            'birth_year.required' => 'Năm sinh là bắt buộc.',
            'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'residence_address.required' => 'Địa chỉ cư trú là bắt buộc.',
            'financial_support_id.exists' => 'Hỗ trợ tài chính không tồn tại.',
            'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
            'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
        ]);


        $financialSupportId = $financialSupportId ? $financialSupportId : null;

        CustomerInterest::create([
            'name' => $validated['full_name'],
            'phone_number' => $validated['phone_number'],
            'financial_support_id' => $financialSupportId,
            'birth_year' => $validated['birth_year'],
            'gender' => $validated['gender'],
            'residence_address' => $validated['residence_address'],
            'business_address' => $validated['business_address'],
            'company_name' => $validated['company_name'],
            'business_field' => $validated['business_field'],
            'tax_code' => $validated['tax_code'],
            'email' => $validated['email'],
            'fanpage' => $validated['fanpage'],
            'support_needs' => $validated['support_needs'],
        ]);

        return redirect()->back()->with('success', 'Gửi thành công!');
    }

}

