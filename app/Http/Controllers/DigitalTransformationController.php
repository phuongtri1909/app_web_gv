<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\DigitalTransformation;
use Intervention\Image\Facades\Image;

class DigitalTransformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $digitalTransformations = DigitalTransformation::where('title', 'like', "%$search%")
                ->paginate(15);
            return view('admin.pages.p17.digital_transformation.index', compact('digitalTransformations'));
        }

        $digitalTransformations = DigitalTransformation::paginate(15);

        return view('admin.pages.p17.digital_transformation.index', compact('digitalTransformations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.p17.digital_transformation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $request->validate([
                'title' => 'required|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,wepb',
                'link' => 'required|url',
            ],[
                'image.required' => 'Ảnh tải lên không được để trống.',
                'image.image' => 'Ảnh phải là một tệp hình ảnh.',
                'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
                'link.required' => 'Liên kết không được để trống.',
                'link.url' => 'Liên kết không hợp lệ.',
                'title.required' => 'Tiêu đề không được để trống.',
                'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            ]);
    
            $digitalTransformation = new DigitalTransformation();

            $digitalTransformation->title = $request->title;
            $digitalTransformation->link = $request->link;

            if ($request->hasFile('image')) {
                
                $image = $request->file('image');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.webp';
                $uploadPath = public_path('uploads/images/digital/' . $folderName);

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $image = Image::make($image->getRealPath());
                $image->resize(370, 160)->encode('webp', 75);
                $image->save($uploadPath . '/' . $fileName);

                $image_path = 'uploads/images/digital/' . $folderName . '/' . $fileName;
            }

            $digitalTransformation->image = $image_path;

            $digitalTransformation->save();
            
            return redirect()->route('digital-transformations.index')
                ->with('success', 'Chuyển đổi số đã được tạo thành công.');
        }catch(\Exception $e){
            return redirect()->back()->withInput()
                ->with('error', 'Đã xảy ra lỗi khi tạo mới, vui lòng thử lại sau.' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($digitalTransformation)
    {

        $digitalTransformation = DigitalTransformation::find($digitalTransformation);

        if (!$digitalTransformation) {
            return redirect()->route('digital-transformations.index')
                ->with('error', 'Chuyển đổi số không tồn tại.');
        }
        return view('admin.pages.p17.digital_transformation.edit', compact('digitalTransformation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $digitalTransformation)
    {

        $digitalTransformation = DigitalTransformation::find($digitalTransformation);

        if (!$digitalTransformation) {
            return redirect()->route('digital-transformations.index')
                ->with('error', 'Chuyển đổi số không tồn tại.');
        }

        try{
            $request->validate([
                'title' => 'required|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,wepb',
                'link' => 'required|url',
            ],[
                'image.image' => 'Ảnh phải là một tệp hình ảnh.',
                'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
                'link.required' => 'Liên kết không được để trống.',
                'link.url' => 'Liên kết không hợp lệ.',
                'title.required' => 'Tiêu đề không được để trống.',
                'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            ]);
    
            $digitalTransformation->title = $request->title;
            $digitalTransformation->link = $request->link;

            if($request->hasFile('image')){

                $image = $request->file('image');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.webp';
                $uploadPath = public_path('uploads/images/digital/' . $folderName);

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $image = Image::make($image->getRealPath());
                $image->resize(370, 160)->encode('webp', 75);
                $image->save($uploadPath . '/' . $fileName);

                $image_path = 'uploads/images/digital/' . $folderName . '/' . $fileName;

                $digitalTransformation->image = $image_path;
            }

            $digitalTransformation->save();
    
            return redirect()->route('digital-transformations.index')
                ->with('success', 'Chuyển đổi số đã được cập nhật thành công.');
        }catch(\Exception $e){
            return redirect()->route('digital-transformations.index')
                ->with('error', 'Đã xảy ra lỗi khi cập nhật, vui lòng thử lại sau.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($digitalTransformation)
    {

        $digitalTransformation = DigitalTransformation::find($digitalTransformation);

        if (!$digitalTransformation) {
            return redirect()->route('digital-transformations.index')
                ->with('error', 'Chuyển đổi số không tồn tại.');
        }

        try{
            $digitalTransformation->delete();
    
            return redirect()->route('digital-transformations.index')
                ->with('success', 'Chuyển đổi số đã được xóa thành công.');
        }catch(\Exception $e){
            return redirect()->route('digital-transformations.index')
                ->with('error', 'Đã xảy ra lỗi khi xóa, vui lòng thử lại sau.');
        }
    }
}
