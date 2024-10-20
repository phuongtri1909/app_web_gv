<?php
namespace App\Http\Controllers;

use App\Models\PersonalBusinessInterest;
use Illuminate\Http\Request;

class PersonalBusinessInterestController extends Controller
{
    public function index()
    {
        $personalBusinessInterests = PersonalBusinessInterest::all();
        return view('admin.pages.personal_business_interests.index', compact('personalBusinessInterests'));
    }

    public function create()
    {
        return view('admin.pages.personal_business_interests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:personal_business_interest,name',
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.unique' => 'Tên này đã tồn tại. Vui lòng chọn tên khác.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
        ]);

        PersonalBusinessInterest::create($request->all());

        return redirect()->route('personal-business-interests.index')->with('success', __('Tạo thành công.'));
    }

    public function edit($id)
    {
        $personalBusinessInterest = PersonalBusinessInterest::findOrFail($id);
        return view('admin.pages.personal_business_interests.edit', compact('personalBusinessInterest'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:personal_business_interest,name,' . $id,
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.unique' => 'Tên này đã tồn tại. Vui lòng chọn tên khác.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
        ]);

        $personalBusinessInterest = PersonalBusinessInterest::findOrFail($id);
        $personalBusinessInterest->update($request->all());

        return redirect()->route('personal-business-interests.index')->with('success', __('Cập nhật thành công.'));
    }

    public function destroy($id)
    {
        $personalBusinessInterest = PersonalBusinessInterest::findOrFail($id);
        $personalBusinessInterest->delete();

        return redirect()->route('personal-business-interests.index')->with('success', __('Xóa thành công.'));
    }
}
