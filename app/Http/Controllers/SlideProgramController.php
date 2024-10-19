<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\SlideProgram;
use App\Models\ProgramOverview;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class SlideProgramController extends Controller
{
    // Hiển thị danh sách các slide program
    public function index($program_id)
    {
        $slidePrograms = SlideProgram::where('program_id' , $program_id)->get();
        return view('admin.pages.slider_program.index', compact('slidePrograms','program_id'));
    }

    // Hiển thị form để tạo một slide program mới
    public function create($program_id)
    {

        $programs = ProgramOverview::pluck('title_program', 'id');
        return view('admin.pages.slider_program.create', compact('programs','program_id'));
    }

    // Lưu một slide program mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $rules = [
            'img.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'program_id' => 'required|exists:program_overview,id',
        ];
    
        $messages = [
            'program_id.required' => __('form.program_id.required'),
            'program_id.exists' => __('form.program_id.exists'),
            'img.*.required' => __('form.img.required'),
            'img.*.image' => __('form.img.image'),
            'img.*.mimes' => __('form.img.mimes'),
            'img.*.max' => __('form.img.max'),
        ];
    
        $request->validate($rules, $messages);
    
        $uploadedImages = [];
    
        try {
            if ($request->hasFile('img')) {
                $images = $request->file('img');
                $folderName = date('Y/m');
                $uploadPath = public_path('uploads/images/slider_program/' . $folderName);
    
                // Kiểm tra và tạo thư mục nếu chưa tồn tại
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }
    
                foreach ($images as $image) {
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $imageName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move($uploadPath, $imageName);
                    $imagePath = 'uploads/images/slider_program/' . $folderName . '/' . $imageName;
    
                    // Lưu thông tin ảnh vào cơ sở dữ liệu
                    $slideProgram = new SlideProgram();
                    $slideProgram->img = $imagePath;
                    $slideProgram->program_id = $request->program_id;
                    $slideProgram->save();
    
                    // Lưu đường dẫn ảnh đã upload thành công
                    $uploadedImages[] = $imagePath;
                }
            }
        } catch (QueryException $e) {
            // Xóa các ảnh đã upload nếu có lỗi xảy ra
            foreach ($uploadedImages as $imagePath) {
                if (File::exists(public_path($imagePath))) {
                    File::delete(public_path($imagePath));
                }
            }
            return back()->withInput()->with('error', __('slide_program_create_error_db.') . $e->getMessage());
        } catch (Exception $e) {
            // Xóa các ảnh đã upload nếu có lỗi xảy ra
            foreach ($uploadedImages as $imagePath) {
                if (File::exists(public_path($imagePath))) {
                    File::delete(public_path($imagePath));
                }
            }
            return back()->withInput()->with('error', __('slide_program_error'));
        }
    
        return redirect()->route('slider_programms.index', $request->program_id)->with('success', __('slide_program_created_success'));
    }

    // Hiển thị form để chỉnh sửa một slide program
    public function edit($id)
    {

        $slideProgram = SlideProgram::findOrFail($id);

        $program_id = $slideProgram->program_id;
        $programs = ProgramOverview::pluck('title_program', 'id');
        return view('admin.pages.slider_program.edit', compact('slideProgram', 'programs','program_id'));
    }

    // Cập nhật một slide program đã tồn tại trong cơ sở dữ liệu
    public function update(Request $request, $id)
    {
        $SlideProgram = SlideProgram::find($id);
        if ($SlideProgram) {
    
            $rules = [
                'program_id' => 'required|exists:program_overview,id',
            ];
    
            $messages = [
                'program_id.required' => __('form.program_id.required'),
                'program_id.exists' => __('form.program_id.exists'),
                'img.file' => __('form.img.file'),
                'img.mimes' => __('form.img.mimes'),
                'img.max' => __('form.img.max'),
            ];
    
            // Nếu có ảnh mới, thêm rule để validate ảnh
            if ($request->hasFile('img')) {
                $rules['img'] = 'required|image';
                $messages['img.required'] = __('form.img.required');
                $messages['img.image'] = __('form.img.image');
            }
    
            // Validate dữ liệu
            $request->validate($rules, $messages);
    
            // Nếu có ảnh mới được tải lên, xử lý lưu ảnh
            if ($request->hasFile('img')) {
                $SlideImage = $request->file('img');
                $folderName = date('Y/m');
                $uploadPath = public_path('uploads/images/slider_program/' . $folderName);
    
                // Kiểm tra và tạo thư mục nếu chưa tồn tại
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }
    
                $originalFileName = pathinfo($SlideImage->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $SlideImage->getClientOriginalExtension();
                $SliderImageName = $originalFileName . '_' . time() . '.' . $extension;
                $SlideImage->move($uploadPath, $SliderImageName);
                $SliderImagePath = 'uploads/images/slider_program/' . $folderName . '/' . $SliderImageName;
    
                // Xóa ảnh cũ nếu tồn tại
                if (isset($SlideProgram->img) && File::exists(public_path($SlideProgram->img))) {
                    File::delete(public_path($SlideProgram->img));
                }
    
                $SlideProgram->img = $SliderImagePath;  // Lưu đường dẫn ảnh mới
            }
    
            $SlideProgram->program_id = $request->program_id;
            $SlideProgram->save();
    
            return redirect()->route('slider_programms.index', $SlideProgram->program_id)->with('success', __('slide_program_update_success'));
        } else {
            return redirect()->back()->with('error', __('slide_program_not_exist_update'));
        }
    }
    

    // Xóa một slide program khỏi cơ sở dữ liệu
    public function destroy($id)
    {
        $slideProgram = SlideProgram::findOrFail($id);
        $program_id = $slideProgram->program_id;
        $slideProgram->delete();
    
        // Chuyển hướng và gửi thông báo thành công
        return redirect()->route('slider_programms.index',  $program_id)
                         ->with('success', __('slide_program_delete_success'));
    }
}