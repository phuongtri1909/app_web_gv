<?php

namespace App\Http\Controllers;

use App\Models\AdCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdCategoryController extends Controller
{
    public function index()
    {
        $adCategories = AdCategory::paginate(10);
        return view('admin.pages.p17.ad_category.index', compact('adCategories'));
    }

    public function create()
    {
        return view('admin.pages.p17.ad_category.create');
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:ad_categories,name',
            ], [
                'name.required' => 'Tên danh mục quảng cáo là bắt buộc.',
                'name.string' => 'Tên danh mục quảng cáo phải là chuỗi ký tự.',
                'name.max' => 'Tên danh mục quảng cáo không được vượt quá 255 ký tự.',
                'name.unique' => 'Tên danh mục quảng cáo đã tồn tại.',
            ]);

            $adCategories = new AdCategory();
            $adCategories->name = $validated['name'];
            $adCategories->slug = Str::slug($validated['name']);
            $adCategories->save();

            return redirect()->route('ad-categories.index')->with('success', 'Danh mục quảng cáo đã được thêm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
        }
    }

    public function edit(AdCategory $ad_category)
    {
        return view('admin.pages.p17.ad_category.edit', compact('ad_category'));
    }
    
    public function update(Request $request, AdCategory $ad_category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:ad_categories,name,' . $ad_category->id,
            ], [
                'name.required' => 'Tên danh mục quảng cáo là bắt buộc.',
                'name.string' => 'Tên danh mục quảng cáo phải là chuỗi ký tự.',
                'name.max' => 'Tên danh mục quảng cáo không được vượt quá 255 ký tự.',
                'name.unique' => 'Tên danh mục quảng cáo đã tồn tại.',
            ]);
    
            $ad_category->name = $validated['name'];
            $ad_category->slug = Str::slug($validated['name']);
            $ad_category->save();
    
            return redirect()->route('ad-categories.index')->with('success', 'Danh mục quảng cáo đã được cập nhật thành công!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
        }
    }
    

    public function destroy(AdCategory $ad_category)
    {
        try {
            $ad_category->delete();
            return redirect()->route('ad-categories.index')->with('success', 'Danh mục quảng cáo đã được xóa thành công!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa danh mục quảng cáo. Vui lòng thử lại!');
        }
    }
}
