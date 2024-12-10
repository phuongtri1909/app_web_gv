<?php

namespace App\Http\Controllers;

use App\Models\AdType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdTypeController extends Controller
{

    public function index()
    {
        $adTypes = AdType::paginate(10);
        return view('admin.pages.p17.ad_types.index', compact('adTypes'));
    }

    public function create()
    {
        return view('admin.pages.p17.ad_types.create');
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:ad_types,name',
            ], [
                'name.required' => 'Tên loại quảng cáo là bắt buộc.',
                'name.string' => 'Tên loại quảng cáo phải là chuỗi ký tự.',
                'name.max' => 'Tên loại quảng cáo không được vượt quá 255 ký tự.',
                'name.unique' => 'Tên loại quảng cáo đã tồn tại.',
            ]);

            $adType = new AdType();
            $adType->name = $validated['name'];
            $adType->slug = Str::slug($validated['name']);
            $adType->save();

            return redirect()->route('ad-types.index')->with('success', 'Loại quảng cáo đã được thêm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
        }
    }

    public function edit(AdType $adType)
    {
        return view('admin.pages.p17.ad_types.edit', compact('adType'));
    }

    public function update(Request $request, AdType $adType)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:ad_types,name,' . $adType->id,
            ], [
                'name.required' => 'Tên loại quảng cáo là bắt buộc.',
                'name.string' => 'Tên loại quảng cáo phải là chuỗi ký tự.',
                'name.max' => 'Tên loại quảng cáo không được vượt quá 255 ký tự.',
                'name.unique' => 'Tên loại quảng cáo đã tồn tại.',
            ]);

            $adType->name = $validated['name'];
            $adType->slug = Str::slug($validated['name']);
            $adType->save();

            return redirect()->route('ad-types.index')->with('success', 'Loại quảng cáo đã được cập nhật thành công!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
        }
    }

    public function destroy(AdType $adType)
    {
        try {
            $adType->delete();
            return redirect()->route('ad-types.index')->with('success', 'Loại quảng cáo đã được xóa thành công!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa loại quảng cáo. Vui lòng thử lại!');
        }
    }
}
