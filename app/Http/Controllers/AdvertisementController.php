<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\AdCategory;
use App\Models\AdType;
use App\Models\Road;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Exception;
use Illuminate\Support\Facades\DB;

class AdvertisementController extends Controller
{
    //
    public function advertising(Request $request)
    {
        $query = Advertisement::with('category', 'road')
            ->where('ad_status', 'active')
            ->orderBy('created_at', 'desc')
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('ad_title', 'like', '%' . $request->search . '%');
            })
            ->when($request->has('price_range'), function ($query) use ($request) {
                $priceRange = explode('-', $request->price_range);
                if (count($priceRange) == 2) {
                    $query->whereBetween(
                        DB::raw("REPLACE(ad_price, '.', '')"),
                        [intval($priceRange[0]), intval($priceRange[1])]
                    );
                } elseif (isset($priceRange[0]) && $priceRange[0] == '5000000') {
                    $query->where(DB::raw("REPLACE(ad_price, '.', '')"), '>', 5000000);
                }
            })
            ->when($request->has('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($query) use ($request) {
                    $query->where('slug', $request->category);
                });
            })
            ->when($request->has('road_id'), function ($query) use ($request) {
                $query->whereHas('road', function ($query) use ($request) {
                    $query->where('slug', $request->road_id);
                });
            })
            ->paginate(10);

        if ($request->ajax()) {
            return view('pages.client.p17.advertising-classifieds.list', compact('query'))->render();
        }
        $categories = AdCategory::all();
        $roads = Road::all();

        return view('pages.client.p17.advertising-classifieds.advertising-classifieds', compact('query', 'categories', 'roads'));
    }



    public function formAdvertising()
    {
        $categories = AdCategory::all();
        $roads = Road::all();
        $types = AdType::all();
        return view('pages.client.p17.advertising-classifieds.form-advertising', compact('categories', 'roads', 'types'));
    }

    public function storeFormAdvertising(Request $request)
    {
        try {
            $validated = $request->validate([
                'ad_title' => 'required|string|max:255',
                'ad_description' => 'nullable|string',
                'ad_price' => 'required',
                'ad_full_name' => 'required|string|max:255',
                'ad_contact_phone' => 'required|string|max:10|regex:/^[0-9]+$/',
                'ad_cccd' => 'nullable|string|max:12|regex:/^[0-9]+$/',
                'category_id' => 'required|exists:ad_categories,id',
                'type_id' => 'required|exists:ad_types,id',
                'road_id' => 'required|exists:roads,id',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif',
            ], [
                'ad_title.required' => 'Tiêu đề quảng cáo là bắt buộc.',
                'ad_title.string' => 'Tiêu đề quảng cáo phải là một chuỗi ký tự.',
                'ad_title.max' => 'Tiêu đề quảng cáo không được vượt quá 255 ký tự.',
                'ad_description.string' => 'Mô tả quảng cáo phải là một chuỗi hợp lệ.',
                'ad_price.required' => 'Vui lòng nhập giá hợp lệ.',
                'ad_full_name.required' => 'Họ và tên của bạn là bắt buộc.',
                'ad_full_name.string' => 'Họ và tên phải là một chuỗi ký tự hợp lệ.',
                'ad_full_name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
                'ad_contact_phone.required' => 'Số điện thoại liên hệ là bắt buộc.',
                'ad_contact_phone.string' => 'Số điện thoại phải là một chuỗi ký tự.',
                'ad_contact_phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',
                'ad_contact_phone.regex' => 'Số điện thoại không hợp lệ, chỉ được chứa các số từ 0-9.',
                'ad_cccd.string' => 'CCCD phải là một chuỗi hợp lệ.',
                'ad_cccd.max' => 'CCCD không được vượt quá 12 ký tự.',
                'ad_cccd.regex' => 'CCCD không hợp lệ, chỉ được chứa các số từ 0-9.',
                'category_id.required' => 'Danh mục quảng cáo là bắt buộc.',
                'category_id.exists' => 'Danh mục quảng cáo đã chọn không hợp lệ.',
                'type_id.required' => 'Loại tin quảng cáo là bắt buộc.',
                'type_id.exists' => 'Loại tin quảng cáo đã chọn không hợp lệ.',
                'road_id.required' => 'Tuyến đường là bắt buộc.',
                'road_id.exists' => 'Tuyến đường đã chọn không hợp lệ.',
                'images.*.image' => 'Mỗi tệp tải lên phải là một hình ảnh.',
                'images.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            ]);

            $ad = new Advertisement();
            $ad->ad_title = $validated['ad_title'];
            $ad->ad_description = $validated['ad_description'] ?? null;
            $ad->ad_price = $validated['ad_price'];
            $ad->ad_full_name = $validated['ad_full_name'];
            $ad->ad_contact_phone = $validated['ad_contact_phone'];
            $ad->ad_cccd = $validated['ad_cccd'] ?? null;
            $ad->category_id = $validated['category_id'];
            $ad->type_id = $validated['type_id'];
            $ad->road_id = $validated['road_id'];
            $ad->slug = Str::slug($validated['ad_title']);
            $ad->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = $originalFileName . '_' . time() . '.webp';
                    $uploadPath = public_path('uploads/images/p17/ads/' . $folderName);
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                    $imageResized = Image::make($image->getRealPath());
                    $imageResized->resize(400, 300)->encode('webp', 75);
                    $imageResized->save($uploadPath . '/' . $fileName);

                    $ad->files()->create([
                        'file_url' => 'uploads/images/p17/ads/' . $folderName . '/' . $fileName,
                        'type' => 'image',
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            return redirect()->route('p17.advertising.client.index')->with('success', 'Đăng tin quảng cáo thành công!');
        } catch (Exception $e) {
            // \Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Lỗi xảy ra. Vui lòng thử lại!');
        }
    }

    public function index()
    {
        $ads = Advertisement::with('category', 'type', 'road')->paginate(10);
        return view('admin.pages.p17.advertisements.index', compact('ads'));
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID format'], 400);
        }

        try {
            $ads = Advertisement::with('category', 'type', 'road','files')->findOrFail($id);

            return response()->json([
                'id' => $ads->id,
                'ad_title' => $ads->ad_title,
                'ad_description' => $ads->ad_description,
                'ad_price' => $ads->ad_price,
                'ad_full_name' => $ads->ad_full_name,
                'ad_contact_phone' => $ads->ad_contact_phone,
                'ad_cccd' => $ads->ad_cccd,
                'category_name' => $ads->category->name,
                'type_name' => $ads->type->name,
                'road_name' => $ads->road->name,
                'ad_status' => $ads->ad_status,
                'files' => $ads->files,
                'created_at' => $ads->created_at,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi không tìm thấy được chi tiết ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID format'], 400);
        }

        try {
            $ads = Advertisement::findOrFail($id);
            $ads->delete();

            return redirect()->route('advertisements.index')->with('success', 'Xóa tin quảng cáo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi không xóa được tin quảng cáo. Vui lòng thử lại!');
        }
    }
}
