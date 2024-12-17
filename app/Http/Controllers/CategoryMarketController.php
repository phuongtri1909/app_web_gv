<?php

namespace App\Http\Controllers;

use App\Models\CategoryMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
class CategoryMarketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoryMarket::all();
        return view('admin.pages.p17.category_market.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.p17.category_market.ce');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'nullable|image|mimes:jpg,png,jpeg,gif',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',

            'banner.image' => 'Ảnh banner phải là một tệp hình ảnh.',
            'banner.mimes' => 'Ảnh banner chỉ chấp nhận các định dạng jpg, png, jpeg, gif.',
        ]);

        try {
            $category = new CategoryMarket();
            $category->name = $request->name;
            $slug = Str::slug($request->input('name'));
            if (CategoryMarket::where('slug', $slug)->exists()) {
                return redirect()->back()->with('error', __('Slug đã tồn tại.'))->withInput();
            }
            $category->slug = $slug;
            if ($request->hasFile('banner')) {
                $image = $request->file('banner');

                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.webp';
                $uploadPath = public_path('uploads/images/p17/category-market/banner/' . $folderName);

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $image = Image::make($image->getRealPath());
                $image->resize(360, 203);
                $image->encode('webp', 75);
                $image->save($uploadPath . '/' . $fileName);

                $bannerPath = 'uploads/images/p17/category-market/banner/' . $folderName . '/' . $fileName;
                $category->banner = $bannerPath;
            }
            $category->save();

            return redirect()->route('category-market.index')->with('success', 'Thêm mới thành công!');
        } catch (\Exception $e) {
            if ($category->banner && File::exists(public_path($category->banner))) {
                File::delete(public_path($$category->banner));
            }
            Log::error('Error occurred while creating category market: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi trong quá trình lưu dữ liệu. Vui lòng thử lại.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = CategoryMarket::findOrFail($id);
        return view('admin.pages.p17.category_market.ce', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'nullable|image|mimes:jpg,png,jpeg,gif',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'banner.image' => 'Ảnh banner phải là một tệp hình ảnh.',
            'banner.mimes' => 'Ảnh banner chỉ chấp nhận các định dạng jpg, png, jpeg, gif.',
        ]);

        try {
            $category = CategoryMarket::findOrFail($id);


            $restrictedSlugs = ['cho-an-nhon', 'cho-tu-phat-can-cu-26a', 'ho-kinh-doanh'];


            if (in_array($category->slug, $restrictedSlugs)) {

                if ($request->name != $category->name) {
                    return redirect()->back()->with('error', 'Không thể sửa tên mục mặc định này.Chỉ được sửa banner')->withInput();
                }


                if ($request->hasFile('banner')) {

                    if ($category->banner && File::exists(public_path($category->banner))) {
                        File::delete(public_path($category->banner));
                    }


                    $image = $request->file('banner');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = $originalFileName . '_' . time() . '.webp';
                    $uploadPath = public_path('uploads/images/p17/category-market/banner/' . $folderName);

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $image = Image::make($image->getRealPath());
                    $image->resize(360, 203);
                    $image->encode('webp', 75);
                    $image->save($uploadPath . '/' . $fileName);

                    $bannerPath = 'uploads/images/p17/category-market/banner/' . $folderName . '/' . $fileName;
                    $category->banner = $bannerPath;
                }

                $category->save();
                return redirect()->route('category-market.index')->with('success', 'Cập nhật banner thành công!');
            }


            $slug = Str::slug($request->input('name'));
            if (CategoryMarket::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                return redirect()->back()->with('error', __('Slug đã tồn tại.'))->withInput();
            }
            $category->slug = $slug;
            $category->name = $request->name;

            if ($request->hasFile('banner')) {

                if ($category->banner && File::exists(public_path($category->banner))) {
                    File::delete(public_path($category->banner));
                }

                // Handle banner upload
                $image = $request->file('banner');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.webp';
                $uploadPath = public_path('uploads/images/p17/category-market/banner/' . $folderName);

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $image = Image::make($image->getRealPath());
                $image->resize(360, 203);
                $image->encode('webp', 75);
                $image->save($uploadPath . '/' . $fileName);

                $bannerPath = 'uploads/images/p17/category-market/banner/' . $folderName . '/' . $fileName;
                $category->banner = $bannerPath;
            }

            $category->save();
            return redirect()->route('category-market.index')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating category market: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi trong quá trình lưu dữ liệu. Vui lòng thử lại.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $restrictedSlugs = ['cho-an-nhon', 'cho-tu-phat-can-cu-26a', 'ho-kinh-doanh'];
            $category = CategoryMarket::findOrFail($id);
            if (in_array($category->slug, $restrictedSlugs)) {
                return redirect()->route('category-market.index')
                    ->with('error', 'Không thể xóa danh mục mặc định.');
            }
            if ($category->banner && File::exists(public_path($category->banner))) {
                File::delete(public_path($category->banner));
            }

            $category->delete();

            return redirect()->route('category-market.index')->with('success', 'Xóa thành công!');
        } catch (ModelNotFoundException $e) {
            Log::error('Error occurred while deleting category market: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Danh mục không tồn tại. Vui lòng thử lại.');
        }
    }
}
