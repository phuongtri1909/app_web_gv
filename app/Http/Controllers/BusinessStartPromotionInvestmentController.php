<?php

namespace App\Http\Controllers;

use App\Models\BusinessStartPromotionInvestment;
use Illuminate\Http\Request;

class BusinessStartPromotionInvestmentController extends Controller
{
    public function index()
    {
        $promotions = BusinessStartPromotionInvestment::with(['business', 'businessSupportNeed'])->get();
        return view('admin.pages.client.form-start-promotion-invertment.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.pages.client.form-start-promotion-invertment.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'business_support_needs_id' => 'required|exists:business_support_needs,id'
        ]);

        BusinessStartPromotionInvestment::create($validatedData);
        return redirect()->route('client.form-start-promotion-invertment.index')->with('success', 'Thêm mới thành công');
    }

    public function show($id)
    {
        $promotion = BusinessStartPromotionInvestment::with(['business', 'businessSupportNeed'])->findOrFail($id);
        return view('admin.pages.client.form-start-promotion-invertment.show', compact('promotion'));
    }

    public function edit($id)
    {
        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        return view('admin.pages.client.form-start-promotion-invertment.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'business_support_needs_id' => 'required|exists:business_support_needs,id'
        ]);

        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        $promotion->update($validatedData);
        return redirect()->route('client.form-start-promotion-invertment.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        $promotion->delete();
        return redirect()->route('client.form-start-promotion-invertment.index')->with('success', 'Xóa thành công');
    }
}

