<?php

namespace App\Http\Controllers;

use App\Models\BankServicesInterest;
use App\Models\CustomerInterest;
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

    public function showForm($financialSupportId)
    {
        $bank_services = BankServicesInterest::all();
        $business_type = PersonalBusinessInterest::all();
        return view('pages.client.gv.form-customer', compact('financialSupportId','bank_services','business_type'));
    }

    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|digits:10',
            'interest' => 'required',
            'bank_service' => 'required',
            'financial_support_id' => 'required|exists:financial_support,id',
            'time' => 'required|string|max:255',
            'otherInput' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.digits' => 'Số điện thoại phải có 10 chữ số.',
            'interest.required' => 'Lĩnh vực quan tâm là bắt buộc.',
            'bank_service.required' => 'Dịch vụ ngân hàng là bắt buộc.',
            'financial_support_id.required' => 'Hỗ trợ tài chính là bắt buộc.',
            'financial_support_id.exists' => 'Hỗ trợ tài chính không tồn tại.',
            'time.required' => 'Thời gian là bắt buộc.',
            'otherInput.max' => 'Giá trị không được vượt quá 255 ký tự.',
        ]);


        $interestId = $validated['interest'];

        $bankServiceId = null;

        if ($validated['bank_service'] === 'other') {
            if (empty($validated['otherInput'])) {
                return redirect()->back()->withErrors(['otherInput' => 'Vui lòng nhập dịch vụ khác.'])->withInput();
            }
            $bankServiceId = BankServicesInterest::create(['name' => $validated['otherInput']])->id;
        } else {
            $bankService = BankServicesInterest::where('id', $validated['bank_service'])->first();
            if (!$bankService) {
                return redirect()->back()->withErrors(['bank_service' => 'Dịch vụ không hợp lệ.'])->withInput();
            }
            $bankServiceId = $validated['bank_service'];
        }
        CustomerInterest::create([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'interest_id' => $interestId,
            'bank_services_id' => $bankServiceId,
            'financial_support_id' => $validated['financial_support_id'],
            'time' => $validated['time'],
        ]);
        return redirect()->back()->with('success', 'Gửi thành công!');
    }



}

