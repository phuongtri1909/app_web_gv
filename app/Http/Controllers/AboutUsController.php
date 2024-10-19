<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tab;
use App\Models\Branch;
use App\Models\AboutUs;
use App\Models\TabDrop;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\TabImgContent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aboutUs = AboutUs::all();
        return view('admin.pages.about_us.index', compact('aboutUs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.about_us.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $locales = Language::pluck('locale')->toArray();
        $rules = [
            'image' => 'required|image',
            'link_url' => 'required|url',
        ];
        $messages = [
            'link_url.required' => __('form.link_url.required'),
            'link_url.url' => __('form.link_url.url'),
            'image.required' => __('form.image.required'),
            'image.image' => __('form.image.image'),
        ];

        foreach ($locales as $locale) {
            $rules["title_about-{$locale}"] = 'required|string|max:255';
            $rules["subtitle_about-{$locale}"] = 'required|string|max:255';
            $rules["title_detail-{$locale}"] = 'required|string|max:255';
            $rules["subtitle_detail-{$locale}"] = 'nullable|string|max:255';
            $rules["description-{$locale}"] = 'required|string';

            $messages["title_about-{$locale}.required"] = __('form.title_about.locale.required', ['locale' => $locale]);
            $messages["subtitle_about-{$locale}.required"] = __('form.subtitle_about.locale.required', ['locale' => $locale]);
            $messages["title_detail-{$locale}.required"] = __('form.title_detail.locale.required', ['locale' => $locale]);
            $messages["subtitle_detail-{$locale}.required"] = __('form.subtitle_detail.locale.required', ['locale' => $locale]);
            $messages["description-{$locale}.required"] = __('form.description.locale.required', ['locale' => $locale]);
        }

        $request->validate($rules, $messages);

        try {
            try {
                if ($request->hasFile('image')) {
                    $imageFile  = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $imageFile->getClientOriginalExtension();
                    $imageFileName  = $originalFileName . '_' . time() . '.' . $extension;
                    $imageFile->move(public_path('uploads/images/about_us/' .  $folderName), $imageFileName);
                    $imageFilePath  = 'uploads/images/about_us/' .  $folderName . '/' . $imageFileName;
                }
            } catch (Exception $e) {
                if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                    File::delete(public_path($imageFilePath));
                }
                return back()->withInput()->with('error', '[E15] ' . __('form.image_url.required'));
            }

            $aboutUs = new AboutUs();

            $translationsTitleAbout = [];
            $translationsSubtitleAbout = [];
            $translationsTitleDetail = [];
            $translationsSubtitleDetail = [];
            $translationsDescription = [];

            foreach ($locales as $locale) {
                $translationsTitleAbout[$locale] = $request->input("title_about-{$locale}");
                $translationsSubtitleAbout[$locale] = $request->input("subtitle_about-{$locale}");
                $translationsTitleDetail[$locale] = $request->input("title_detail-{$locale}");
                $translationsSubtitleDetail[$locale] = $request->input("subtitle_detail-{$locale}");
                $translationsDescription[$locale] = $request->input("description-{$locale}");
            }
            $translationsTitleAbout[$request->locale] = $request->title_about;
            $translationsSubtitleAbout[$request->locale] = $request->subtitle_about;
            $translationsTitleDetail[$request->locale] = $request->title_detail;
            $translationsSubtitleDetail[$request->locale] = $request->subtitle_detail;
            $translationsDescription[$request->locale] = $request->description;

            $aboutUs->setTranslations('title_about', $translationsTitleAbout);
            $aboutUs->setTranslations('subtitle_about', $translationsSubtitleAbout);
            $aboutUs->setTranslations('title_detail', $translationsTitleDetail);
            $aboutUs->setTranslations('subtitle_detail', $translationsSubtitleDetail);
            $aboutUs->setTranslations('description', $translationsDescription);

            $aboutUs->image = $imageFilePath;
            $aboutUs->link_url = $request->input('link_url');
            $aboutUs->save();
        } catch (QueryException $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error', '[E16] ' . __('about_us_create_error_db'));
        } catch (Exception $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error', '[E17] ' . __('create_new_about_us_error'));
        }
        return redirect()->route('aboutUs.index')->with('success', __('create_about_us_success'));
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
    public function edit($id)
    {
        $aboutUs = AboutUs::find($id);

        if ($aboutUs) {
            $languages = Language::all();
            $translatedTitleAbout = json_decode($aboutUs->getAttributes()['title_about'], true);
            $translatedSubTitleAbout = json_decode($aboutUs->getAttributes()['subtitle_about'], true);
            $translatedTitleDetail = json_decode($aboutUs->getAttributes()['title_detail'], true);
            $translatedSubTitleDetail = json_decode($aboutUs->getAttributes()['subtitle_detail'], true);
            $translatedDescriptions = json_decode($aboutUs->getAttributes()['description'], true);

            $allLocales = $languages->pluck('locale')->toArray();

            foreach ($allLocales as $locale) {
                if (!array_key_exists($locale, $translatedTitleAbout)) {
                    $translatedTitleAbout[$locale] = '';
                }
                if (!array_key_exists($locale, $translatedDescriptions)) {
                    $translatedDescriptions[$locale] = '';
                }
                if (!array_key_exists($locale, $translatedSubTitleAbout)) {
                    $translatedSubTitleAbout[$locale] = '';
                }
                if (!array_key_exists($locale, $translatedTitleDetail)) {
                    $translatedTitleDetail[$locale] = '';
                }
                if (!array_key_exists($locale, $translatedSubTitleDetail)) {
                    $translatedSubTitleDetail[$locale] = '';
                }
            }
            return view('admin.pages.about_us.edit', compact(
                'aboutUs',
                'translatedTitleAbout',
                'translatedDescriptions',
                'translatedSubTitleAbout',
                'translatedTitleDetail',
                'translatedSubTitleDetail',
                'languages'
            ));
        }
        return redirect()->route('aboutUs.index')->with('error', '[E18] ' . __('about_us_not_found'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $locales = Language::pluck('locale')->toArray();
        $aboutUs = AboutUs::find($id);


        if (!$aboutUs) {
            return redirect()->route('aboutUs.index')->with('error', '[E19] ' . __('about_us_not_found'));
        }

        $rules = [
            'image' => 'nullable|image',
            'link_url' => 'required|url',
        ];
        $messages = [
            'link_url.required' => __('form.link_url.required'),
            'link_url.url' => __('form.link_url.url'),
            'image.image' => __('form.image.image'),
        ];

        foreach ($locales as $locale) {
            $rules["title_about-{$locale}"] = 'required|string|max:255';
            $rules["subtitle_about-{$locale}"] = 'required|string|max:255';
            $rules["title_detail-{$locale}"] = 'required|string|max:255';
            $rules["subtitle_detail-{$locale}"] = 'nullable|string|max:255';
            $rules["description-{$locale}"] = 'required|string';

            $messages["title_about-{$locale}.required"] = __('form.title_about.locale.required', ['locale' => $locale]);
            $messages["subtitle_about-{$locale}.required"] = __('form.subtitle_about.locale.required', ['locale' => $locale]);
            $messages["title_detail-{$locale}.required"] = __('form.title_detail.locale.required', ['locale' => $locale]);
            $messages["subtitle_detail-{$locale}.required"] = __('form.subtitle_detail.locale.required', ['locale' => $locale]);
            $messages["description-{$locale}.required"] = __('form.description.locale.required', ['locale' => $locale]);
        }



        $validatedData = $request->validate($rules, $messages);

        try {
            $imageFilePath = $aboutUs->image;

            if ($request->hasFile('image')) {
                if (File::exists(public_path($aboutUs->image))) {
                    File::delete(public_path($aboutUs->image));
                }

                $imageFile = $request->file('image');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $imageFile->getClientOriginalExtension();
                $imageFileName  = $originalFileName . '_' . time() . '.' . $extension;
                $imageFile->move(public_path('uploads/images/about_us/' .  $folderName), $imageFileName);
                $imageFilePath  = 'uploads/images/about_us/' .  $folderName . '/' . $imageFileName;

                $aboutUs->image = $imageFilePath;
            }
            $translations = [];
            foreach ($locales as $locale) {
                $translations['title_about'][$locale] = $request->input("title_about-{$locale}");
                $translations['subtitle_about'][$locale] = $request->input("subtitle_about-{$locale}");
                $translations['title_detail'][$locale] = $request->input("title_detail-{$locale}");
                $translations['subtitle_detail'][$locale] = $request->input("subtitle_detail-{$locale}");
                $translations['description'][$locale] = $request->input("description-{$locale}");
            }
            $aboutUs->setTranslations('title_about', $translations['title_about']);
            $aboutUs->setTranslations('subtitle_about', $translations['subtitle_about']);
            $aboutUs->setTranslations('title_detail', $translations['title_detail']);
            $aboutUs->setTranslations('subtitle_detail', $translations['subtitle_detail']);
            $aboutUs->setTranslations('description', $translations['description']);

            $aboutUs->link_url = $validatedData['link_url'];
            $aboutUs->save();
        } catch (QueryException $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error', '[E16] ' . __('about_us_update_error_db'));
        } catch (Exception $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error', '[E17] ' . __('update_about_us_error'));
        }
        return redirect()->route('aboutUs.index')->with('success', __('update_about_us_success'));
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            return redirect()->route('aboutUs.index')->with('error', '[E18] ' . __('about_us_not_found.'));
        }

        try {
            if ($aboutUs->image && File::exists(public_path($aboutUs->image))) {
                File::delete(public_path($aboutUs->image));
            }

            $aboutUs->delete();
        } catch (Exception $e) {
            return redirect()->route('aboutUs.index')->with('error', '[E19] ' . __('about_us_delete_error'));
        }

        return redirect()->route('aboutUs.index')->with('success', __('about_us_deleted_successfully'));
    }


    public function pageAboutUsDetail(Request $request,$slug)
    {
        $keyPages = ['about-us', 'about-us-philosophy', 'about-us-collapse', 'about-us-component-3'];
        $tab = Tab::where('slug', $slug)
            ->whereIn('key_page', $keyPages)
            ->first();
        if (!$tab) {
            return abort(404);
        } else {
            if ($tab->slug == 'school-board-message') {

                $content_first = $tab->imgContents->first();
                $collapses = $tab->drops;

                $campus_brighton = $request->cookie('campus_brighton');
                if ($campus_brighton) {
                    $campus = Branch::where('id', $campus_brighton)->first();
                    if (!$campus) {
                        $campus = Branch::first();
                        $campus = Branch::first();
                        if (!$campus) {
                            $personnel = null;
                        } else {
                            $personnel = $campus->personnel;
                        }
                    }else{
                        $personnel = $campus->personnel;
                    }
                   
                } else {
                    $campus = Branch::first();
                    if (!$campus) {
                        $personnel = null;
                    } else {
                        $personnel = $campus->personnel;
                    }
                }

                $campuses = Branch::get();
               
                return view('pages.aboutUs.tab.school-board-message', compact('tab', 'content_first', 'collapses', 'campus', 'personnel', 'campuses'));
            } elseif ($tab->slug == 'brighton-academy') {
                $content_first = $tab->imgContents->first();
                $tab_component3 = Tab::where('key_page', 'about-us-component-3')->first();
                if (!$tab_component3) {
                    $component_3 = null;
                } else {
                    $component_3 = $tab_component3->imgContents;
                }

                $tab_philosophy = Tab::where('key_page', 'about-us-philosophy')->first();
                if (!$tab_philosophy) {
                    $philosophy = null;
                } else {
                    $philosophy = $tab_philosophy->drops;
                }

                $tab_collapse = Tab::where('key_page', 'about-us-collapse')->first();

                if (!$tab_collapse) {
                    $collapses = null;
                } else {
                    $collapses = $tab_collapse->drops;
                }


                return view('pages.aboutUs.index', compact('tab', 'content_first', 'component_3', 'philosophy', 'collapses'));
            } else {
                $component_2 = $tab->imgContents->where('section_type','component_1')->first();
                
                $components_3 = $tab->imgContents()->where('section_type','component_2')->get();

                return view('pages.tab-custom.index', compact('tab','component_2','components_3'));
            }
        }
    }

    public function tabIndex()
    {
        $component_2 = Tab::where('slug', 'brighton-academy')->first();

        $component_3 = Tab::where('slug', 'component-3')->first();

        $philosophy = Tab::where('slug', 'our-philosophy')->first();

        $collapses = Tab::where('slug', 'component-collapse')->first();
        return view('admin.pages.about_us.tab_about_us.index', compact('component_2', 'component_3', 'philosophy', 'collapses'));
    }


    public function tabEdit($tab_img_content_id)
    {
        $tab_img_content = TabImgContent::find($tab_img_content_id);
        if (!$tab_img_content) {
            return redirect()->back()->with('error', __('Data_not_found'));
        }

        $keyPages = ['about-us', 'about-us-philosophy', 'about-us-collapse', 'about-us-component-3'];
        $tab = $tab_img_content->tab()->whereIn('key_page', $keyPages)->first();
        if (!$tab) {
            return redirect()->back()->with('error', __('Data_tab_not_found_no_update'));
        }
        $languages = Language::all();

        return view('admin.pages.about_us.tab_about_us.edit_img_content', compact('tab', 'tab_img_content', 'languages'));
    }

    public function tabUpdate(Request $request, $tab_img_content_id)
    {
        $tab_img_content = TabImgContent::find($tab_img_content_id);
        if (!$tab_img_content) {
            return redirect()->back()->with('error', __('Data_not_found'));
        }
        $keyPages = ['about-us', 'about-us-philosophy', 'about-us-collapse', 'about-us-component-3'];
        $tab = $tab_img_content->tab()->whereIn('key_page', $keyPages)->first();
        if (!$tab) {
            return redirect()->back()->with('error', __('Data_tab_not_found_no_update'));
        }


        $locales = Language::pluck('locale')->toArray();

        if ($tab->slug != 'brighton-academy') {
            if ($request->hasFile('image')) {
                $rules = [
                    'image' => 'required|image',
                ];
                $messages = [
                    'image.required' => __('form.image.required'),
                    'image.image' => __('form.image.image'),
                ];
            }
        }


        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'required|string|max:255';
            $rules["content_{$locale}"] = 'required|string';

            $messages["title_{$locale}.required"] = __('form.title.locale.required', ['locale' => $locale]);
            $messages["content_{$locale}.required"] = __('form.content.locale.required', ['locale' => $locale]);
        }

        $request->validate($rules, $messages);

        try {
            try {
                if ($request->hasFile('image')) {
                    $imageFile  = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $imageFileName  = $originalFileName . '_' . time() . '.webp'; // Đổi định dạng sang WebP
                    
                    $destinationPath = public_path('uploads/images/about_us/' .  $folderName);
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true);
                    }
            
                    $image = Image::make($imageFile->getRealPath());
                    $image->encode('webp', 75)
                      ->save($destinationPath . '/' . $imageFileName);
            
                    $imageFilePath  = 'uploads/images/about_us/' .  $folderName . '/' . $imageFileName;
                    $tab_img_content->image = $imageFilePath;
                }
            } catch (Exception $e) {
                if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                    File::delete(public_path($imageFilePath));
                }
                return back()->withInput()->with('error',  __('no_save_image'));
            }

            $translationsTitle = [];
            $translationsDescription = [];

            foreach ($locales as $locale) {
                $translationsTitle[$locale] = $request->input("title_{$locale}");
                $translationsDescription[$locale] = $request->input("content_{$locale}");
            }

            $tab_img_content->setTranslations('title', $translationsTitle);
            $tab_img_content->setTranslations('content', $translationsDescription);

            $tab_img_content->save();

            return redirect()->route('tab.aboutUs.edit',$tab_img_content->id)->with('success', __('update_success'));
        } catch (QueryException $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error',  __('error_save_db'));
        } catch (Exception $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error',  __('error_save'));
        }
    }


    public function allDataComponent($slug)
    {

        $keyPages = ['about-us', 'about-us-philosophy', 'about-us-collapse', 'about-us-component-3'];
        $tab = Tab::where('slug', $slug)->whereIn('key_page', $keyPages)->first();
        if (!$tab) {
            return redirect()->back()->with('error', __('Data_not_found'));
        }
        $languages = Language::all();
        $tabs_img_content = $tab->imgContents;
        return view('admin.pages.about_us.tab_about_us.component_3.index', compact('tab', 'languages', 'tabs_img_content'));
    }

    public function allDataComponentCollapse($slug)
    {
        $keyPages = ['about-us', 'about-us-philosophy', 'about-us-collapse'];
        $tab = Tab::where('slug', $slug)->whereIn('key_page', $keyPages)->first();
        if (!$tab) {
            return redirect()->back()->with('error', __('Data_not_found'));
        }
        $languages = Language::all();
        $tabs_collapse = $tab->drops;
        return view('admin.pages.about_us.tab_about_us.collapse.index', compact('tab', 'languages', 'tabs_collapse'));
    }

    public function createCollapse($tab_id){

        $keyPages = ['about-us', 'about-us-philosophy', 'about-us-collapse'];

        $tab = Tab::where('id',$tab_id)->whereIn('key_page',$keyPages)->first();
        if(!$tab){
            return redirect()->back()->with('error', __('Data_tab_not_found_no_create'));
        }

        $languages = Language::all();
        return view('admin.pages.about_us.tab_about_us.collapse.create',compact('tab','languages'));

    }

    public function storeCollapse(Request $request,$id)
    {
        $keyPages = ['about-us', 'about-us-philosophy', 'about-us-collapse'];

        $tab = Tab::where('id',$id)->whereIn('key_page',$keyPages)->first();
        if(!$tab){
            return redirect()->back()->with('error', __('Data_tab_not_found_no_create'));
        }
        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'required|string|max:255';
            $rules["content_{$locale}"] = 'required|string';

            $messages["title_{$locale}.required"] = __('title_required');
            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.required"] = __('content_required');
            $messages["content_{$locale}.string"] = __('content_string');
        }


        if($tab->slug == 'our-philosophy')
        {
            $rules['bg_color'] = 'nullable|string|max:255';
            $messages['bg_color.string'] = __('bg_color_string');
            $messages['bg_color.max'] = __('bg_color_max', ['max' => 255]);
        }

        $rules['image'] = 'required|mimes:jpg,jpeg,png,gif|max:20480';

        $messages['image.required'] = __('image_required');
        $messages['image.mimes'] = __('image_mimes');
        $messages['image.max'] = __('image_max');

        $validatedData = $request->validate($rules, $messages);

        try {
            $tab_drop_content = new TabDrop();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/content/' . $folderName), $fileName);
                $tab_drop_content->image = 'uploads/images/content/' . $folderName . '/' . $fileName;
            }

            $translateTitle = [];
            $translateContent = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateContent[$locale] = $request->get("content_{$locale}");
            }

            $tab_drop_content->setTranslations('title', $translateTitle);
            $tab_drop_content->setTranslations('content', $translateContent);
            $tab_drop_content->bg_color = $request->input('bg_color');
            $tab_drop_content->tab_id = $id;
            $tab_drop_content->save();


            return redirect()->route('all.data.component.collapse', $tab->slug)->with('success', __('create_success'));

        } catch (\Exception $e) {
            if (isset($tab_drop_content->image) && File::exists(public_path($tab_drop_content->image))) {
                File::delete(public_path($tab_drop_content->image));
            }
            return back()->with(['error' => __('store_error') . $e->getMessage()])->withInput();
        }
    }

    public function editCollapse($tab_drop_id)
    {
        $keyPages = ['about-us', 'about-us-philosophy', 'about-us-collapse'];

        $tab_drop = TabDrop::find($tab_drop_id);
        if(!$tab_drop){
            return redirect()->back()->with('error', __('Data_not_found'));
        }

        $tab = $tab_drop->tab()->whereIn('key_page',$keyPages)->first();
        if(!$tab){
            return redirect()->back()->with('error', __('Data_tab_not_found_no_update'));
        }


        $languages = Language::all();
        return view('admin.pages.about_us.tab_about_us.collapse.edit',compact('tab','tab_drop','languages'));
    }

    public function updateCollapse(Request $request,$tab_collapse_id)
    {
        $keyPages = ['about-us', 'about-us-philosophy', 'about-us-collapse'];

        $tab_drop = TabDrop::find($tab_collapse_id);
        if(!$tab_drop){
            return redirect()->back()->with('error', __('Data_not_found'));
        }

        $tab = $tab_drop->tab()->whereIn('key_page',$keyPages)->first();

        if(!$tab){
            return redirect()->back()->with('error', __('Data_tab_not_found_no_update'));
        }
       
        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'required|string|max:255';
            $rules["content_{$locale}"] = 'required|string';

            $messages["title_{$locale}.required"] = __('title_required');
            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.required"] = __('content_required');
            $messages["content_{$locale}.string"] = __('content_string');
        }


        if($tab->slug == 'our-philosophy')
        {
            $rules['bg_color'] = 'nullable|string|max:255';
            $messages['bg_color.string'] = __('bg_color_string');
            $messages['bg_color.max'] = __('bg_color_max', ['max' => 255]);
        }

        if($request->hasFile('image'))
        {
            $rules['image'] = 'nullable|mimes:jpg,jpeg,png,gif|max:20480';

            $messages['image.mimes'] = __('image_mimes');
            $messages['image.max'] = __('image_max');
        }

        $validatedData = $request->validate($rules, $messages);

        try {

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/content/' . $folderName), $fileName);

                $imageBackup = $tab_drop->image;

                $tab_drop->image = 'uploads/images/content/' . $folderName . '/' . $fileName;
            }

            $translateTitle = [];
            $translateContent = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateContent[$locale] = $request->get("content_{$locale}");
            }

            $tab_drop->setTranslations('title', $translateTitle);
            $tab_drop->setTranslations('content', $translateContent);
            $tab_drop->bg_color = $request->input('bg_color');
            $tab_drop->save();

            if (isset($imageBackup) && File::exists(public_path($imageBackup))) {
                File::delete(public_path($imageBackup));
            }

            return redirect()->route('all.data.component.collapse', $tab->slug)->with('success', __('create_success'));

        } catch (\Exception $e) {
            if (isset($tab_drop_content->image) && File::exists(public_path($tab_drop_content->image))) {
                File::delete(public_path($tab_drop_content->image));
            }
            return back()->with(['error' => __('store_error') . $e->getMessage()])->withInput();
        }
    }

    public function destroyCollapse($tab_drop_id)
    {
        $keyPages = ['about-us', 'about-us-philosophy', 'about-us-collapse'];

        $tab_drop = TabDrop::find($tab_drop_id);
        if(!$tab_drop){
            return redirect()->back()->with('error', __('Data_not_found'));
        }

        $tab = $tab_drop->tab()->whereIn('key_page',$keyPages)->first();
        if(!$tab){
            return redirect()->back()->with('error', __('Data_tab_not_found_no_delete'));
        }

        try {
            if ($tab_drop->image && File::exists(public_path($tab_drop->image))) {
                File::delete(public_path($tab_drop->image));
            }

            $tab_drop->delete();
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('Data_delete_error'));
        }
        return redirect()->route('all.data.component.collapse', $tab->slug)->with('success', __('Data_deleted_successfully'));
    
    }

    public function tabIndexMessage(){

        $tab = Tab::where('slug','school-board-message')->first();

        if(!$tab){
            return redirect()->back()->with('error', __('tab_not_found'));
        }
        return view('admin.pages.about_us.tab_message.index',compact('tab'));

    }

    public function tabAboutUs(){
        $excludedSlugs = ['school-board-message', 'brighton-academy'];
        $tabs = Tab::where('key_page','about-us')
                    ->whereNotIn('slug', $excludedSlugs)
                    ->get();

        return view('admin.pages.about_us.tab_about_us.tab-custom.index',compact('tabs'));
    }
}
