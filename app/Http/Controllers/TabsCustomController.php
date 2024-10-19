<?php

namespace App\Http\Controllers;

use App\Models\Tab;
use App\Models\Language;
use App\Models\TabCustom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TabImgContent;
use Illuminate\Support\Facades\File;

class TabsCustomController extends Controller
{

    private $key_pages = ['admissions', 'programs', 'about-us', 'environment'];

    private $specialSlugs = [
        'admissions-process',
        'phuong-phap-giao-duc', 'phat-trien-cac-du-an-mini', 'for-parent', 'brighton-academy',
        'component-3', 'our-philosophy', 'component-collapse', 'school-board-message',
        'programs-content', 'advisory-board', 'learn-environment'
    ];

    private function isSpecialTab($slug)
    {
        return in_array($slug, $this->specialSlugs);
    }

    private function redirectToKeyPage($key_page)
    {
        switch ($key_page) {
            case 'admissions':
                return redirect()->route('tabs-admissions.index')->with('success', __('create_tab_admission_success'));
            case 'programs':
                return redirect()->route('tabs-programs.index')->with('success', __('create_tab_program_success'));
            case 'about-us':
                return redirect()->route('tabs-about-us.index')->with('success', __('create_tab_about_us_success'));
            case 'environment':
                return redirect()->route('tabs-environment.index')->with('success', __('create_tab_environment_success'));
            default:
                return redirect()->back()->with('error', __('no_find_data_page'));
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($key_page)
    {
        if (!in_array($key_page, $this->key_pages)) {
            return redirect()->back()->with('error', __('no_find_data_page'));
        }

        $languages = Language::all();
        return view('admin.pages.tab-custom.create', compact('key_page','languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$key_page)
    {

        if (!in_array($key_page, $this->key_pages)) {
            return redirect()->back()->with('error', __('no_find_data_page'));
        }

        $locales = Language::pluck('locale')->toArray();

        $rules = [
            'banner' => 'required|mimes:jpg,jpeg,png,gif,mp4,avi|max:20480',
        ];
        $messages = [
            'banner.required' => __('banner_required'),
            'banner.mimes' => __('banner_mimes'),
            'banner.max' => __('banner_max'),
        ];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'required|string|max:255';

            $messages["title_{$locale}.required"] = __('title_required');
            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
        }

        $slug = Str::slug($request->title_en);


        if (Tab::where('slug', $slug)->exists()) {
            return back()->with('error', __('slug_exists'));
        }

        $validatedData = $request->validate($rules, $messages);


        try{
            try {
                $image = $request->file('banner');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/banner/' . $folderName), $fileName);
                $image_path = 'uploads/images/banner/' . $folderName . '/' . $fileName;
            } catch (\Exception $e) {
                if (isset($image_path) && File::exists(public_path($image_path))) {
                    File::delete(public_path($image_path));
                }
                return back()->withInput()->with('error', __('upload_banner_error'));
            }

            $tab = new Tab();

            $translateTitle = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
            }

            $tab->setTranslations('title', $translateTitle);

            $tab->slug = $slug;
            $tab->key_page = $key_page;
            $tab->banner = $image_path;
            $tab->save();

            switch ($key_page) {
                case 'admissions':
                    return redirect()->route('tabs-admissions.index')->with('success', __('create_tab_admission_success'));
                    break;
                case 'programs':
                    return redirect()->route('tabs-programs.index')->with('success', __('create_tab_program_success'));
                    break;
                case 'about-us':
                    return redirect()->route('tabs-about-us.index')->with('success', __('create_tab_about_us_success'));
                    break;
                case 'environment':
                    return redirect()->route('tabs-environment.index')->with('success', __('create_tab_environment_success'));
                    break;
                default:
                    return redirect()->back()->with('error', __('no_find_data_page'));
                    break;
            }
        }catch(\Exception $e){
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('create_tab_menu_error')])->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($slug)
    {

        $tab = Tab::where('slug',$slug)->first();
        $languages = Language::all();
        if (!$tab) {
            return redirect()->route('tabs-admissions.index')->with('error', __('tab_not_found'));
        }

        elseif($this->isSpecialTab($tab->slug)){
            return redirect()->route('tabs-admissions.index')->with('error', __('tab_not_found'));
        }

        return view('admin.pages.tab-custom.index_content', compact('tab', 'languages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lug){
        $tab = Tab::where('slug',$lug)->first();
        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }
      
        $languages = Language::all();

        return view('admin.pages.tab-custom.edit',compact('tab','languages'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$slug){
        $tab = Tab::where('slug',$slug)->first();
        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        if ($request->hasFile('banner')) {
            $rules = [
                'banner' => 'required|mimes:jpg,jpeg,png,gif|max:20480',
            ];
            
            $messages = [
                'banner.required' => __('banner_required'),
                'banner.mimes' => __('banner_mimes'),
                'banner.max' => __('banner_max'),
            ];
        }

        $locales = Language::pluck('locale')->toArray();

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'required|string|max:255';

            $messages["title_{$locale}.required"] = __('title_required');
            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
        }

        $validatedData = $request->validate($rules, $messages);

        try {
            if ($request->hasFile('banner')) {
                $image = $request->file('banner');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/banner/' . $folderName), $fileName);

                $imageBackup = $tab->banner;

                $imagePathh = 'uploads/images/banner/' . $folderName . '/' . $fileName;
                $tab->banner = $imagePathh;
            }

            $translateTitle = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
            }

            $tab->setTranslations('title', $translateTitle);
            $tab->save();

            if (isset($imageBackup) && File::exists(public_path($imageBackup))) {
                $imagePath = public_path($imageBackup);
                $allowedDirectory = public_path('images');

                if (strpos(realpath($imagePath), realpath($allowedDirectory)) !== 0) {
                    File::delete($imagePath);
                }
            }

            return redirect()->back()->with('success', __('update_success'));

        } catch (\Exception $e) {
            if (isset($imagePathh) && File::exists(public_path($imagePathh))) {
                File::delete(public_path($imagePathh));
            }
            return back()->with(['error' => __('update_tab_error') . $e->getMessage()])->withInput();
        }

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tab = Tab::findOrFail($id);
        if (!$tab) {
            return redirect()->route('tabs-admissions.index')->with('error', __('tab_not_found'));
        }elseif($this->isSpecialTab($tab->slug)){
            return redirect()->route('tabs-admissions.index')->with('error', __('tab_not_found'));
        }
        try {
            $tab->delete();
            return redirect()->back()->with('success', __('delete_tab_menu_success'));
        } catch (\Exception $e) {
            return redirect()->route('tabs-admissions.index')->with('error', __('delete_tab_menu_error'));
        }
    }

    public function createContent1Tab($slug)
    {
        $tab = Tab::where('slug',$slug)->first();
        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        if($this->isSpecialTab($tab->slug))
        {
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        $languages = Language::all();

        $img_content = TabImgContent::where('tab_id',$tab->id)->where('section_type','component_1')->first();
        if($img_content){
            return view('admin.pages.tab-custom.edit_content1',compact('img_content','languages','tab'));
        }
        return view('admin.pages.tab-custom.create_content1',compact('tab','languages'));
    }

    public function storeContent1Tab(Request $request , $slug)
    {
        $tab = Tab::where('slug',$slug)->first();

        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        $locales = Language::pluck('locale')->toArray();

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $validatedData = $request->validate($rules, $messages);

        try{
            $translateTitle = [];
            $tranSlateContent = [];
    
            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $tranSlateContent[$locale] = $request->get("content_{$locale}");
            }

            $tab_content = new TabImgContent();
            $tab_content->setTranslations('title', $translateTitle);
            $tab_content->setTranslations('content', $tranSlateContent);
            $tab_content->tab_id = $tab->id;
            $tab_content->section_type = 'component_1';
            $tab_content->save();

            return redirect()->route('content_tab_custom', $tab->slug)->with('success', __('create_content_tab_success'));
        }catch(\Exception $e){
            return back()->with(['error' => __('create_content_tab_error')])->withInput();
        }
    }

    public function updateContent1Tab(Request $request,$id)
    {
        $tab_content = TabImgContent::findOrFail($id);
        $tab = Tab::findOrFail($tab_content->tab_id);
        if(!$tab_content){
            return redirect()->back()->with('error', __('content_not_found'));
        }

        $locales = Language::pluck('locale')->toArray();

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $validatedData = $request->validate($rules, $messages);

        try{
            $translateTitle = [];
            $tranSlateContent = [];
    
            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $tranSlateContent[$locale] = $request->get("content_{$locale}");
            }

            $tab_content->setTranslations('title', $translateTitle);
            $tab_content->setTranslations('content', $tranSlateContent);
            $tab_content->save();

            return redirect()->route('content_tab_custom', $tab->slug)->with('success', __('custom_content_tab_success'));
        }catch(\Exception $e){
            return back()->with(['error' => __('custom_content_tab_error')])->withInput();
        }
    }
    

    public function allContent($slug)
    {
        $tab = Tab::where('slug',$slug)->first();
        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        if($this->isSpecialTab($tab->slug))
        {
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        $languages = Language::all();

        $tabs_content = TabImgContent::where('tab_id',$tab->id)->where('section_type','component_2')->get();
        return view('admin.pages.tab-custom.all_content',compact('tabs_content','tab','languages'));
    }

    public function createContent2Tab($slug)
    {
        $tab = Tab::where('slug',$slug)->first();
        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        if($this->isSpecialTab($tab->slug))
        {
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        $languages = Language::all();
        return view('admin.pages.tab-custom.create_content2',compact('tab','languages'));
    }

    public function storeContent2Tab(Request $request , $slug)
    {
        $tab = Tab::where('slug',$slug)->first();

        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        $locales = Language::pluck('locale')->toArray();

        $rules = [
            'image' => 'required|image|mimes:jpg,jpeg,png,gif',  
        ];
        $messages = [
            'image.required' => __('image_required'),
            'image.image' => __('image_image'),
            'image.mimes' => __('image_mimes'),
        ];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $validatedData = $request->validate($rules, $messages);

        try{
            $translateTitle = [];
            $tranSlateContent = [];
    
            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $tranSlateContent[$locale] = $request->get("content_{$locale}");
            }
    
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

            $tab_content = new TabImgContent();
            $tab_content->setTranslations('title', $translateTitle);
            $tab_content->setTranslations('content', $tranSlateContent);
            $tab_content->image = $image_path;
            $tab_content->tab_id = $tab->id;
            $tab_content->section_type = 'component_2';
            $tab_content->save();

            return redirect()->route('all.content', $tab->slug)->with('success', __('create_content_tab_success', ['tab' => $tab->title]));
        }catch(\Exception $e){
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('create_content_tab_error',['tab' => $tab->title])])->withInput();
        }
       
    }

    public function editContent2Tab($id)
    {
        $tab_content = TabImgContent::findOrFail($id);
        if(!$tab_content){
            return redirect()->back()->with('error', __('content_not_found'));
        }
        $tab = Tab::where('id',$tab_content->tab_id)->first();

        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }
        
        if($this->isSpecialTab($tab->slug))
        {
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        $languages = Language::all();
        return view('admin.pages.tab-custom.edit_content2',compact('tab_content','tab','languages'));
    }

    public function updateContent2Tab(Request $request,$id)
    {
        $tab_content = TabImgContent::findOrFail($id);
        
        if(!$tab_content){
            return redirect()->back()->with('error', __('content_not_found'));
        }

        $tab = Tab::where('id',$tab_content->tab_id)->first();

        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        if ($request->hasFile('image')) {
            $rules = [
                'image' => 'required|image|mimes:jpg,jpeg,png,gif',  
            ];
            $messages = [
                'image.required' => __('image_required'),
                'image.image' => __('image_image'),
                'image.mimes' => __('image_mimes'),
            ];
        }

        $locales = Language::pluck('locale')->toArray();

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $validatedData = $request->validate($rules, $messages);

        try{
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/tab_content/' . $folderName), $fileName);

                $imageBackup = $tab_content->image;

                $imagePathh = 'uploads/images/tab_content/' . $folderName . '/' . $fileName;
                $tab_content->image = $imagePathh;
            }

            $translateTitle = [];
            $tranSlateContent = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $tranSlateContent[$locale] = $request->get("content_{$locale}");
            }

            $tab_content->setTranslations('title', $translateTitle);
            $tab_content->setTranslations('content', $tranSlateContent);
            $tab_content->save();
            
            if (isset($imageBackup) && File::exists(public_path($imageBackup))) {
                $imagePath = public_path($imageBackup);
                $allowedDirectory = public_path('images');

                if (strpos(realpath($imagePath), realpath($allowedDirectory)) !== 0) {
                    File::delete($imagePath);
                }
            }

            return redirect()->route('all.content', $tab->slug)->with('success', __('update_success'));

        } catch (\Exception $e) {

            if (isset($imagePathh) && File::exists(public_path($imagePathh))) {
                File::delete(public_path($imagePathh));
            }
            return back()->with(['error' => __('update_error') . $e->getMessage()])->withInput();
        }

    }

    public function destroyContent2Tab($id)
    {
        $tab_content = TabImgContent::findOrFail($id);
        if (!$tab_content) {
            return redirect()->back()->with('error', __('content_not_found'));
        }

        $tab = Tab::where('id',$tab_content->tab_id)->first();

        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        if($this->isSpecialTab($tab->slug))
        {
            return redirect()->back()->with('error', __('tab_not_found'));
        }

        try {
            $tab_content->delete();
            return redirect()->back()->with('success', __('delete_content_tab_success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('delete_content_tab_error'));
        }
    }

}
