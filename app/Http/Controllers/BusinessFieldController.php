<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BusinessField;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BusinessFieldController extends Controller
{
    public function index()
    {
        $businessFields = BusinessField::paginate(25);
        return view('admin.pages.business_field.index', compact('businessFields'));
    }

    public function create()
    {
        return view('admin.pages.business_field.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg', // Giới hạn kích thước tệp tối đa 10MB
        ], [
            'name.required' => 'Vui lòng nhập tên ngành nghề kinh doanh.',
            'icon.required' => 'Vui lòng chọn biểu tượng ngành nghề kinh doanh.',
            'icon.image' => 'Biểu tượng ngành nghề kinh doanh phải là một tệp ảnh.',
            'icon.mimes' => 'Biểu tượng ngành nghề kinh doanh phải là một tệp ảnh có định dạng: jpeg, png, jpg, gif, svg.',
            'icon.max' => 'Biểu tượng ngành nghề kinh doanh không được lớn hơn 10MB.',
        ]);

        $slug = Str::slug($request->input('name'), '-');

        if (DB::table('business_fields')->where('slug', $slug)->exists()) {
            return back()->withErrors(['name' => 'Tên ngành nghề kinh doanh đã tồn tại.']);
        }

        DB::beginTransaction();
        try {
            if ($request->hasFile('icon')) {
                $icon = $request->file('icon');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($icon->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.webp';
                $uploadPath = public_path('/uploads/icons/' . $folderName);

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                // Sử dụng Intervention/Image để thay đổi kích thước và giảm dung lượng ảnh
                $img = Image::make($icon->getRealPath());
                $img->resize(45, 45)->encode('webp', 75);
                $img->save($uploadPath . '/' . $fileName);

                $iconPath = 'uploads/icons/' . $folderName . '/' . $fileName;
            }

            $businessField = new BusinessField();
            $businessField->name = $request->name;
            $businessField->icon = $iconPath;
            $businessField->slug = Str::slug($request->name);
            $businessField->save();

            DB::commit();
            return redirect()->route('business-fields.index')
                ->with('success', 'Tạo ngành nghề kinh doanh thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($iconPath) && File::exists(public_path($iconPath))) {
                File::delete(public_path($iconPath));
            }
            return back()->withInput()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function edit($id)
    {
        $businessField = BusinessField::findOrFail($id);
        return view('admin.pages.business_field.edit', compact('businessField'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'name.required' => 'Vui lòng nhập tên ngành nghề kinh doanh.',
            'icon.image' => 'Biểu tượng ngành nghề kinh doanh phải là một tệp ảnh.',
            'icon.mimes' => 'Biểu tượng ngành nghề kinh doanh phải là một tệp ảnh có định dạng: jpeg, png, jpg, gif, svg.',
            'icon.max' => 'Biểu tượng ngành nghề kinh doanh không được lớn hơn 10MB.',
        ]);

        $businessField = BusinessField::findOrFail($id);
        $slug = Str::slug($request->input('name'), '-');

        if ($businessField->slug != $slug && DB::table('business_fields')->where('slug', $slug)->exists()) {
            return back()->withErrors(['name' => 'Tên ngành nghề kinh doanh đã tồn tại.']);
        }

        DB::beginTransaction();
        try {
            if ($request->hasFile('icon')) {
                $icon = $request->file('icon');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($icon->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.webp';
                $uploadPath = public_path('/uploads/icons/' . $folderName);

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                // Sử dụng Intervention/Image để thay đổi kích thước và giảm dung lượng ảnh
                $img = Image::make($icon->getRealPath());
                $img->resize(45, 45)->encode('webp', 75);
                $img->save($uploadPath . '/' . $fileName);

                $iconPath = 'uploads/icons/' . $folderName . '/' . $fileName;

                $backUpIcon = $businessField->icon;

                $businessField->icon = $iconPath;
                
            }



            $businessField->name = $request->name;
            $businessField->slug = Str::slug($request->name);
            $businessField->save();

            DB::commit();

            if (File::exists(public_path($backUpIcon))) {
                $filePath = public_path($backUpIcon);
                if (!str_contains($filePath, public_path('images'))) {
                    File::delete($filePath);
                }
            }

            return redirect()->route('business-fields.index')
                ->with('success', 'Cập nhật ngành nghề kinh doanh thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($iconPath) && File::exists(public_path($iconPath))) {
                File::delete(public_path($iconPath));
            }
            return back()->withInput()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function destroy($id)
    {
        $businessField = BusinessField::findOrFail($id);
        DB::beginTransaction();
        try {
            $businessField->delete();
            DB::commit();

            if (File::exists(public_path($businessField->icon))) {
                File::delete(public_path($businessField->icon));
            }

            return redirect()->route('business-fields.index')
                ->with('success', 'Xóa ngành nghề kinh doanh thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }
}
