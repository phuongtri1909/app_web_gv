<?php

namespace App\Http\Controllers;

use App\Models\AdmissionProcess;
use App\Models\Tab;
use App\Models\Language;
use App\Models\TabImgContent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Monolog\Handler\IFTTTHandler;

class TabAdmissionController extends Controller
{
    public function index()
    {
        $tabs_admission = Tab::where('key_page', 'admissions')->get();
        return view('admin.pages.tab_tuyensinh.index', compact('tabs_admission'));
    }

    public function show($id)
    {
        $tab = Tab::findOrFail($id);
        $languages = Language::all();
        if (!$tab) {
            return redirect()->route('tabs-admissions.index')->with('error', __('tab_admission_not_found'));
        }

        if($tab->key_page != 'admissions'){
            return redirect()->route('tabs-admissions.index')->with('error', __('tab_admission_not_found'));
        }

        $tab_image_content = TabImgContent::where('tab_id', $tab->id)->first();

        switch ($tab->slug) {
            case 'admissions-process':
                $admissions_process = AdmissionProcess::get();
                
                return view('admin.pages.tab_tuyensinh.show_process', compact('tab', 'tab_image_content', 'admissions_process', 'languages'));
                break;
            case 'tuition-fees':
            case 'refund-tuition-fees':
            case 'school-calendar':
                return redirect()->route('all.content', $tab->slug);

                //cai cu
                return view('admin.pages.tab_tuyensinh.tab.edit', compact('tab', 'languages', 'tab_image_content'));
                break;
            default:
                return redirect()->route('tabs-admissions.index')->with('error', __('tab_admission_not_found'));
                break;
        }

    }

    public function updateContentTab(Request $request, $tab_img_content_id)
    {
        $tab_img_content = TabImgContent::findOrFail($tab_img_content_id);

        $locales = Language::pluck('locale')->toArray();

        if($request->hasFile('image')){
            $rules = [
                'image' => 'image|mimes:jpg,jpeg,png,gif',  
            ];
            $messages = [
                'image.image' => __('image_image'),
                'image.mimes' => __('image_mimes'),
            ];
        }

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $validatedData = $request->validate($rules, $messages);

        try{
            if($request->hasFile('image')){
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/tab_content/' . $folderName), $fileName);
                    $image_path = 'uploads/images/tab_content/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }
              
                $backup = $tab_img_content->image;
                $tab_img_content->image = $image_path;
            }

            $translateTitle = [];
            $tranSlateContent = [];
    
            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $tranSlateContent[$locale] = $request->get("content_{$locale}");
            }
    
            $tab_img_content->setTranslations('title', $translateTitle);
            $tab_img_content->setTranslations('content', $tranSlateContent);
            $tab_img_content->save();
            if (isset($backup) && File::exists(public_path($backup))) {
                File::delete(public_path($backup));
            }
            return redirect()->route('tabs-admissions.show', $tab_img_content->tab_id)->with('success', __('update_content_tab_success'));
        }catch(\Exception $e){
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('update_content_tab_error') . $e->getMessage()])->withInput();
        }
    }
}
