<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Slider;
use App\Models\Language;
use App\Models\SlideProgram;
use Illuminate\Http\Request;
use App\Models\DetailContent;
use App\Models\CategoryProgram;
use App\Models\ProgramOverview;
use App\Models\Tab;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class DetailContentController extends Controller
{
    public function index($program_id)
    {

        $detailContents = DetailContent::where('program_id' , $program_id)->get();

        return view('admin.pages.detail_contents.index', compact('detailContents','program_id'));
    }   

    // Hiển thị form tạo mới DetailContent
    public function create($program_id)
    {

        $languages = Language::all();
        $compo = [
            'cp1' => 'Component 1',
            'cp2' => 'Component 2',
            'cp3' => 'Component 3'
        ];
        return view('admin.pages.detail_contents.create', compact('program_id','compo','languages'));
    }

    // Xử lý việc lưu DetailContent mới
    public function store(Request $request)
    {
        $locales = Language::pluck('locale')->toArray();
        $rules = [
            'img_detail' => 'required|image',
            'program_id' => 'required|exists:program_overview,id',
            'key_components' => 'required|string|in:cp1,cp2,cp3',
        ];
    
        $messages = [
            'program_id.required' => __('form.program_id.required'),
            'program_id.exists' => __('form.program_id.exists'),
        
            'title-*.required' => __('form.title.required'),
            'title-*.string' => __('form.title.string'),
            'title-*.max' => __('form.title.max'),
        
            'content-*.required' => __('form.content.required'),
            'content-*.string' => __('form.content.string'),
        
            'img_detail.required' => __('form.img_detail.required'),
            'img_detail.file' => __('form.img_detail.file'),
            'img_detail.mimes' => __('form.img_detail.mimes'),
            'img_detail.max' => __('form.img_detail.max'),
    
            //'tag-*.string' => __('form.content.tag'),
            
            'key_components.string' => __('form.content.key_components'),
            'key_components.in' => __('form.content.key_components.in'),
        ];
    
        foreach ($locales as $locale) {
            $rules["title-{$locale}"] = 'required|string|max:255';
            $rules["content-{$locale}"] = 'required|string';
            $rules["tag-{$locale}"] = 'nullable|string';
    
            $messages["title-{$locale}.required"] = __('form.title.locale.required', ['locale' => $locale]);
            $messages["content-{$locale}.required"] = __('form.content.locale.required', ['locale' => $locale]);
            $messages["tag-{$locale}.string"] = __('form.content.tag.string');
        }
        $request->validate($rules, $messages);
        
        try {
            try {
                if ($request->hasFile('img_detail')) {
                    $detailImage = $request->file('img_detail');
                    $folderName = date('Y/m');
    
                    // Kiểm tra và tạo thư mục nếu chưa tồn tại
                    $uploadPath = public_path('uploads/images/detail_contents/' . $folderName);
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
    
                    $originalFileName = pathinfo($detailImage->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $detailImage->getClientOriginalExtension();
                    $detailImageName = $originalFileName . '_' . time() . '.' . $extension;
                    $detailImage->move($uploadPath, $detailImageName);
                    $detailImagePath = 'uploads/images/detail_contents/' . $folderName . '/' . $detailImageName;
                }
            } catch (Exception $e) {
                if (isset($detailImagePath) && File::exists(public_path($detailImagePath))) {
                    File::delete(public_path($detailImagePath));
                }
                return back()->withInput()->with('error', '[E15] ' . __('form.image_url.required'));
            }
    
            $detail = new DetailContent();
            $translationsTitleDetail = [];
            $translationsContent = [];
            $translationsTag = [];
    
            foreach ($locales as $locale) {
                $translationsTitleDetail[$locale] = $request->input("title-{$locale}");
                $translationsContent[$locale] = $request->input("content-{$locale}");
                $translationsTag[$locale] = $request->input("tag-{$locale}");
    
            }
            $detail->setTranslations('content', $translationsContent);
            $detail->setTranslations('title', $translationsTitleDetail);
            $detail->setTranslations('tag', $translationsTag);
            $detail->img_detail = $detailImagePath;
            $detail->program_id = $request->program_id;
            $detail->key_components = $request->key_components;
    
            $detail->save();
    
        } catch (QueryException $e) { 
            if (isset($detailImagePath) && File::exists(public_path($detailImagePath))) {
                File::delete(public_path($detailImagePath));
            }
            return back()->withInput()->with('error', __('detail_contents_create_error_db.') . $e->getMessage());
        } catch (Exception $e) {
            if (isset($detailImagePath) && File::exists(public_path($detailImagePath))) {
                File::delete(public_path($detailImagePath));
            }
            return back()->withInput()->with('error', __('detail_contents_program_error'));
        }
    
        return redirect()->route('detail_contents.index', $request->program_id)->with('success', __('detail_contents_create_success'));
    }
    

    // Hiển thị thông tin chi tiết của DetailContent
    public function show($id)
    {
        $detailContent = DetailContent::findOrFail($id);
        return view('detail_contents.show', compact('detailContent'));
    }

    // Hiển thị form chỉnh sửa DetailContent
    public function edit($id)
    {   
        $languages = Language::all();
        $compo = [
            'cp1' => 'Component 1',
            'cp2' => 'Component 2',
            'cp3' => 'Component 3'
        ];
        $detailContent = DetailContent::findOrFail($id);
        $program_id = $detailContent->program_id;
        return view('admin.pages.detail_contents.edit', compact('detailContent','program_id','compo','languages'));
    }
    
    // Xử lý việc cập nhật DetailContent
    public function update(Request $request, $id)
    {
       
        $detailContent = DetailContent::find($id);
        if($detailContent){
            
            $locales = Language::pluck('locale')->toArray();
            $rules = [           
                'program_id' => 'required|exists:program_overview,id',
                'key_components' => 'required|string|in:cp1,cp2,cp3',
            ];
        
            $messages = [
                'program_id.required' => __('form.program_id.required'),
                'program_id.exists' => __('form.program_id.exists'),
            
                'title-*.required' => __('form.title.required'),
                'title-*.string' => __('form.title.string'),
            
                'content-*.required' => __('form.content.required'),
                'content-*.string' => __('form.content.string'),
    
                'key_components.string' => __('form.content.key_components'),
                'key_components.in' => __('form.content.key_components.in'),
            ];
            
            foreach ($locales as $locale) {
                $rules["title-{$locale}"] = 'required|string|max:255';
                $rules["content-{$locale}"] = 'required|string';
               
                
                $messages["title-{$locale}.required"] = __('form.title.locale.required', ['locale' => $locale]);
                $messages["content-{$locale}.required"] = __('form.content.locale.required', ['locale' => $locale]);
            }
            if($request->file('img_detail')) {
                $rules = [
                    'img_detail' => 'required|image',
                ];
    
                $messages = [
                    'img_detail.required' => __('form.img_detail.required'),
                    'img_detail.image' => __('form.img_detail.image'),
                ];
            } 
            $request->validate($rules, $messages);
            if ($request->hasFile('img_detail')) {
                $detailImage = $request->file('img_detail');
                $folderName = date('Y/m');

                // Kiểm tra và tạo thư mục nếu chưa tồn tại
                $uploadPath = public_path('uploads/images/detail_contents/' . $folderName);
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }
 
                $backup = $detailContent->img_detail;

                $originalFileName = pathinfo($detailImage->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $detailImage->getClientOriginalExtension();
                $detailImageName = $originalFileName . '_' . time() . '.' . $extension;
                $detailImage->move($uploadPath, $detailImageName);
                $detailImagePath = 'uploads/images/detail_contents/' . $folderName . '/' . $detailImageName;
                $detailContent->img_detail = $detailImagePath;
            }

           
            $translationsTitleDetail = [];
            $translationsContent = [];
            $translationsTag = [];
    
            foreach ($locales as $locale) {
                $translationsTitleDetail[$locale] = $request->input("title-{$locale}");
                $translationsContent[$locale] = $request->input("content-{$locale}");
                $translationsTag[$locale] = $request->input("tag-{$locale}");
    
            }
                     
            $detailContent->setTranslations('content', $translationsContent);
            $detailContent->setTranslations('title', $translationsTitleDetail);
            $detailContent->setTranslations('tag', $translationsTag);
           
            
            $detailContent->program_id = $request->program_id;
            $detailContent->key_components = $request->key_components;
    
            $detailContent->save();
            if (isset($backup) && File::exists(public_path($backup))) {
                File::delete(public_path($backup));
            }
            return redirect()->route('detail_contents.index', $detailContent->program_id)->with('success', __('detail_contents_update_success'));
        }
        else {
            return redirect()->back()->with('error', __('detail_contents_update_error'));
        }
    }

    // Xử lý việc xóa DetailContent
    public function destroy(Request $request, $id)
    {
        // Tìm bản ghi và xóa
        $detailContent = DetailContent::findOrFail($id);
        $program_id = $detailContent->program_id;
        $detailContent->delete();
    
        // Chuyển hướng và gửi thông báo thành công
        return redirect()->route('detail_contents.index',  $program_id)
                         ->with('success', __('detail_contents_delete_success'));
    }    

    public function pageDetailProgram($id)
    {
        $category_key_cb2 = CategoryProgram::where('key_page', 'key_cb2')->first();
        if (!empty($category_key_cb2->programs)) {
            $programs_cp2 = $category_key_cb2->programs()->orderBy('rank', 'asc')->get();
        } else {
            $programs_cp2 = null;
        }

        $sliders = Slider::where('active', 'yes')
            ->where('key_page', 'key_program_detail')
            ->get();

        $detail_program = ProgramOverview::findOrFail($id);
        $content_programs_cp1 = DetailContent::where('program_id', $id)
                                            ->where('key_components', 'cp1')  
                                            ->get();
        
        $content_programs_cp2 = DetailContent::where('program_id', $id)
        ->where('key_components', '!=', 'cp1')
        ->get();

        $slides_program = SlideProgram::where('program_id', $id)->get();
        $tab = Tab::where('slug', 'programs-content')->first();

        return view('pages.detail-program', compact('tab','category_key_cb2','programs_cp2', 'sliders','detail_program','content_programs_cp1','content_programs_cp2','slides_program'));
    }
}
