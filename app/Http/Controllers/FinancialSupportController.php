<?php

namespace App\Http\Controllers;

use App\Models\FinancialSupport;
use Illuminate\Http\Request;

class FinancialSupportController extends Controller
{
    // Show the list of financial support entries
    public function index()
    {
        $financialSupports = FinancialSupport::all();
        return view('financial_support.index', compact('financialSupports'));
    }

    // Show form to create a new financial support entry
    public function create()
    {
        return view('financial_support.create');
    }

    // Store a new financial support entry
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.vi' => 'required|string|max:255',
            'slug' => 'required|string|unique:financial_supports,slug',
            'avt_financial_support' => 'nullable|string',
        ]);

        FinancialSupport::create([
            'name' => json_encode($request->input('name')),
            'slug' => $request->input('slug'),
            'avt_financial_support' => $request->input('avt_financial_support'),
        ]);

        return redirect()->route('financial_support.index')->with('success', 'Financial Support created successfully.');
    }

    // Show a single financial support entry
    public function show($id)
    {
        $financialSupport = FinancialSupport::findOrFail($id);
        return view('financial_support.show', compact('financialSupport'));
    }

    // Show form to edit a financial support entry
    public function edit($id)
    {
        $financialSupport = FinancialSupport::findOrFail($id);
        return view('financial_support.edit', compact('financialSupport'));
    }

    // Update the financial support entry
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.vi' => 'required|string|max:255',
            'slug' => 'required|string|unique:financial_supports,slug,' . $id,
            'avt_financial_support' => 'nullable|string',
        ]);

        $financialSupport = FinancialSupport::findOrFail($id);
        $financialSupport->update([
            'name' => json_encode($request->input('name')),
            'slug' => $request->input('slug'),
            'avt_financial_support' => $request->input('avt_financial_support'),
        ]);

        return redirect()->route('financial_support.index')->with('success', 'Financial Support updated successfully.');
    }

    // Delete a financial support entry
    public function destroy($id)
    {
        $financialSupport = FinancialSupport::findOrFail($id);
        $financialSupport->delete();

        return redirect()->route('financial_support.index')->with('success', 'Financial Support deleted successfully.');
    }

    public function showFinancial(){
        $financialSupports = FinancialSupport::all();
        return view('pages.client.gv.home-post', compact('financialSupports'));
    }
}
