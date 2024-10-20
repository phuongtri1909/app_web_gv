<?php

namespace App\Http\Controllers;

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

    public function showForm(){

        return view('pages.client.gv.form-customer');
    }
}

