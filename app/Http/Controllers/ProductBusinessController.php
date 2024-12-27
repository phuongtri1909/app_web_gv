<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\BusinessMember;
use App\Models\ProductBusiness;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use App\Models\CategoryProductBusiness;

class ProductBusinessController extends Controller
{
    public function connectSupplyDemand()
    {
        $categoryProductBusinesses = CategoryProductBusiness::all();
        return view('pages.client.form-connect-supply-demand', compact('categoryProductBusinesses'));
    }

    public function storeConnectSupplyDemand(Request $request)
    {
        DB::beginTransaction();


        try {

            $business_member_id = $this->getBusinessMemberId($request);
            

            //dd($request->all());
            $request->validate([
                'name_product' => 'required|string|max:255',
                'description' => 'required|string',
                'category_product_id' => 'required|exists:category_product_businesses,id',
                'price' => 'required|numeric',
                'price_member' => 'required|numeric',
                'product_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
                'product_images' => 'required|array|max:4',
                'product_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
                'related_confirmation_document.*' => 'mimes:pdf,doc,docx',
            ],[
                'product_avatar.required' => 'Ảnh đại diện sản phẩm không được để trống',
                'product_avatar.image' => 'Ảnh sản phẩm phải là ảnh',
                'product_avatar.mimes' => 'Ảnh sản phẩm phải có định dạng jpeg, png, jpg, gif, webp',
                'product_images.*.image' => 'Ảnh sản phẩm phải là ảnh',
                'product_images.*.mimes' => 'Ảnh sản phẩm phải có định dạng jpeg, png, jpg, gif, webp',
                'product_images.array' => 'Ảnh sản phẩm không hợp lệ',
                'product_images.max' => 'Ảnh sản phẩm tối đa 4 ảnh',
                'product_images.*.required' => 'Ảnh sản phẩm không được để trống',
                'product_images.required' => 'Ảnh sản phẩm không được để trống',
                'related_confirmation_document.*.mimes' => 'Tài liệu phải có định dạng pdf, doc, docx',
                'price.required' => 'Giá sản phẩm không được để trống',
                'price.numeric' => 'Giá sản phẩm phải là số',
                'price_member.required' => 'Giá thành viên không được để trống',
                'price_member.numeric' => 'Giá thành viên phải là số',
                'category_product_id.required' => 'Danh mục sản phẩm không được để trống',
                'category_product_id.exists' => 'Danh mục sản phẩm không tồn tại',
                'name_product.required' => 'Tên sản phẩm không được để trống',
                'name_product.string' => 'Tên sản phẩm phải là chuỗi',
                'name_product.max' => 'Tên sản phẩm không được quá 255 ký tự',
                'description.required' => 'Mô tả sản phẩm không được để trống',
                'description.string' => 'Mô tả sản phẩm phải là chuỗi',
            ]);


            $recaptchaResponse = $request->input('g-recaptcha-response');
            $secretKey = env('RECAPTCHA_SECRET_KEY');
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $recaptchaResponse,
            ]);

            $responseBody = json_decode($response->body());

            if (!$responseBody->success) {
                return redirect()->back()->withErrors(['error' => 'Vui lòng xác nhận bạn không phải là robot.'])->withInput();
            }


            // Handle product avatar
            if ($request->hasFile('product_avatar')) {
                # code...
                $avatar = $request->file('product_avatar');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.webp';
                $uploadPath = public_path('uploads/images/avatar/' . $folderName);

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $image = Image::make($avatar->getRealPath());
                $image->resize(500, 500)->encode('webp', 75);
                $image->save($uploadPath . '/' . $fileName);

                $avatar_path = 'uploads/images/avatar/' . $folderName . '/' . $fileName;
            }

            // Handle related confirmation documents
            $relatedDocuments = [];
            if ($request->hasFile('related_confirmation_document')) {
                foreach ($request->file('related_confirmation_document') as $document) {
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = $originalFileName . '_' . time() . '.' . $document->getClientOriginalExtension();
                    $uploadPath = public_path('uploads/documents/' . $folderName);

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $document->move($uploadPath, $fileName);

                    $relatedDocuments[] = 'uploads/documents/' . $folderName . '/' . $fileName;
                }
            }

            $slug = $this->generateUniqueSlug($request->name_product);

            $productBusiness = ProductBusiness::create([
                'business_member_id' => $business_member_id,
                'category_product_id' => $request->category_product_id,
                'name_product' => $request->name_product,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'price_member' => $request->price_member,
                'product_avatar' => $avatar_path,
                'related_confirmation_document' => json_encode($relatedDocuments),
            ]);

            // Handle product images
            if ($request->hasFile('product_images')) {
                foreach ($request->file('product_images') as $image) {
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = $originalFileName . '_' . time() . '.webp';
                    $uploadPath = public_path('uploads/images/products/' . $folderName);

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $img = Image::make($image->getRealPath());
                    $img->encode('webp', 75);
                    $img->save($uploadPath . '/' . $fileName);

                    $image_path = 'uploads/images/products/' . $folderName . '/' . $fileName;

                    ProductImage::create([
                        'product_id' => $productBusiness->id,
                        'image' => $image_path,
                        'thumbnail' => $image_path,
                    ]);
                }
            }

            DB::commit();
            
            return redirect()->route('business.products')->with('success', 'Đăng ký kết nối cung cầu thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Đăng ký thất bại.');
        }
    }

    private function generateUniqueSlug($name_product)
    {
        $slug = Str::slug($name_product);
        $originalSlug = $slug;
        $counter = 1;

        while (ProductBusiness::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $category_product = $request->input('search-category');
        $business_member_id = $request->input('search-member-id');
        $search_status = $request->input('search-status');

        $products = ProductBusiness::query();

        if ($search) {
            $products = $products->where(function ($query) use ($search) {
                $query->where('name_product', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('price', 'like', '%' . $search . '%')
                    ->orWhere('price_member', 'like', '%' . $search . '%');
            });
        }

        if ($category_product) {
            $products = $products->where('category_product_id', $category_product);
        }

        if ($business_member_id) {
            $products = $products->where('business_member_id', $business_member_id);
        }

        if ($search_status) {
            $products = $products->where('status', $search_status);
        }

        $category_products = CategoryProductBusiness::all();
        $business_members = BusinessMember::all();

        $products = $products->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.pages.client.form-business-product.index', compact('products', 'category_products', 'business_members'));
    }

    public function show($id)
    {
        $product = ProductBusiness::with(['businessMember', 'categoryProduct', 'productImages'])->findOrFail($id);

        return view('admin.pages.client.form-business-product.show', compact('product'));
    }

    public function destroy($id)
    {
        $product = ProductBusiness::findOrFail($id);
        $product->delete();
        return redirect()->route('business.products.index')->with('success', 'Xoá sản phẩm thành công!');
    }
}
