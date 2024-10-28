<?php

namespace App\Http\Controllers;

use App\Models\BusinessStartPromotionInvestment;
use Illuminate\Http\Request;

class BusinessStartPromotionInvestmentController extends Controller
{
    public function index()
    {
        $promotions = BusinessStartPromotionInvestment::with(['business', 'businessSupportNeed'])->get();
        return view('admin.pages.business-promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.pages.business-promotions.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'business_support_needs_id' => 'required|exists:business_support_needs,id'
        ]);

        BusinessStartPromotionInvestment::create($validatedData);
        return redirect()->route('business-promotions.index')->with('success', 'Thêm mới thành công');
    }

    public function show($id)
    {
        $promotion = BusinessStartPromotionInvestment::with(['business', 'businessSupportNeed'])->findOrFail($id);
        return view('admin.pages.business-promotions.show', compact('promotion'));
    }

    public function edit($id)
    {
        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        return view('admin.pages.business-promotions.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'business_support_needs_id' => 'required|exists:business_support_needs,id'
        ]);

        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        $promotion->update($validatedData);
        return redirect()->route('business-promotions.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $promotion = BusinessStartPromotionInvestment::findOrFail($id);
        $promotion->delete();
        return redirect()->route('business-promotions.index')->with('success', 'Xóa thành công');
    }
}

