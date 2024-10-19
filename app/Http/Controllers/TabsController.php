<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Tab;
use App\Models\TabCustom;
use App\Models\TabDrop;
use App\Models\TabImgContent;
use App\Models\TabProject;
use App\Models\TabProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class TabsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tabs_programs = Tab::where('key_page', 'programs')->get();
        return view('admin.pages.tab_chuongtrinh.index', compact('tabs_programs'));
    }

    public function createComponent2($id)
    {
        $tab = Tab::find($id);
        if (!$tab || $tab->slug != 'phuong-phap-giao-duc') {
            return back()->with('error', __('no_find_data'));
        }

        $languages = Language::all();
        return view('admin.pages.tab_chuongtrinh.show_program.create_drop_content', compact('tab','languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeComponent2(Request $request,$id)
    {
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

        $rules['icon'] = 'nullable|string|max:255';
        $rules['bg_color'] = 'nullable|string|max:255';
        $rules['image'] = 'nullable|mimes:jpg,jpeg,png,gif|max:5120';

        $messages['icon.string'] = __('icon_string');
        $messages['icon.max'] = __('icon_max', ['max' => 255]);
        $messages['bg_color.string'] = __('bg_color_string');
        $messages['bg_color.max'] = __('bg_color_max', ['max' => 255]);
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
            $tab_drop_content->icon = $request->input('icon');
            $tab_drop_content->bg_color = $request->input('bg_color');
            $tab_drop_content->tab_id = $id;
            $tab_drop_content->save();


            return redirect()->route('tabs-programs.component2', $id)->with('success', __('drop_success'));

        } catch (\Exception $e) {
            if (isset($tab_drop_content->image) && File::exists(public_path($tab_drop_content->image))) {
                File::delete(public_path($tab_drop_content->image));
            }
            return back()->with(['error' => __('store_error') . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tab = Tab::findOrFail($id);

        if ($tab->key_page != 'programs') {
            return redirect()->route('tabs-programs.index')->with('error', __('tab_program_not_found'));
        }

        switch ($tab->slug) {
            case 'phuong-phap-giao-duc':
                $tab_image_content = TabImgContent::where('tab_id', $tab->id)->first();
                $tab_drops = TabDrop::all();
                $languages = Language::all();
                return view('admin.pages.tab_chuongtrinh.show_program', compact('tab', 'tab_image_content', 'tab_drops', 'languages'));

            case 'phat-trien-cac-du-an-mini':
                $tab_image_content = TabImgContent::where('tab_id', $tab->id)->get();
                $tab_drops = TabDrop::all();
                $languages = Language::all();
                $tab_projects = TabProject::all();
                return view('admin.pages.tab_chuongtrinh.show_pp', compact('tab', 'tab_image_content', 'tab_drops', 'languages','tab_projects'));

            default:
            return redirect()->route('tabs-programs.index')->with('error', __('tab_program_not_found'));
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function showComponent1($id)
    {
        $tab = Tab::findOrFail($id);
        $tab_image_content = TabImgContent::where('tab_id', $tab->id)->get();

        if ($tab_image_content->isEmpty()) {
            return redirect()->back()->with('error', __('no_content_found'));
        }
        $languages = Language::all();
        return view('admin.pages.tab_chuongtrinh.show_program.show_img_content', compact('tab', 'tab_image_content', 'languages'));
    }




    public function showComponent1PP($id)
    {
        $tab = Tab::findOrFail($id);
        $tab_image_content = TabImgContent::where('tab_id', $tab->id)->get();

        // if ($tab_image_content->isEmpty()) {
        //     return redirect()->back()->with('error', __('no_content_found'));
        // }
        $languages = Language::all();
        return view('admin.pages.tab_chuongtrinh.show_program_pp.show_img_content', compact('tab', 'tab_image_content', 'languages'));
    }

    public function createContentComponent1PP($id)
    {
        $tab = Tab::find($id);
        if (!$tab) {
            return back()->with('error', __('no_find_data'));
        }
        $languages = Language::all();
        return view('admin.pages.tab_chuongtrinh.show_program_pp.create_img_content', compact('tab', 'languages'));
    }

    public function storeContentComponent1PP(Request $request, $id)
    {

        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        $rules = [
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'section_type' => 'nullable|string|max:50',

        ];
        $messages = [
            'image.image' => __('image_image'),
            'image.mimes' => __('image_mimes'),
            'section_type.string' => __('section_type_string'),
            'section_type.max' => __('section_type_max', ['max' => 50])

        ];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }
        $validatedData = $request->validate($rules, $messages);

        try {
            $translateTitle = [];
            $tranSlateContent = [];
            $image_path = null;

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $tranSlateContent[$locale] = $request->get("content_{$locale}");
            }

            if ($request->hasFile('image')) {
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
            }

            $tab_content = new TabImgContent();
            $tab_content->setTranslations('title', $translateTitle);
            $tab_content->setTranslations('content', $tranSlateContent);
            $tab_content->image = $image_path;
            $tab_content->tab_id = $id;
            $tab_content->save();
            return redirect()->route('tabs-programs.component1pp', $id)->with('success', __('create_content_tab_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            // dd($e);
            return back()->with(['error' => __('create_content_tab_error')])->withInput();
        }

    }

    public function editContentComponent1PP($id)
    {
        $tab_image_content = TabImgContent::where('id', $id)->first();
        $languages = Language::all();

        if (!$tab_image_content) {
            return redirect()->back()->with('error', __('no_content_found'));
        }
        return view('admin.pages.tab_chuongtrinh.show_program_pp.edit_img_content', compact('tab_image_content', 'languages'));


    }
    public function updateContentComponent1PP(Request $request, $id)
    {
        $tab_image_content = TabImgContent::findOrFail($id);

        if (!$tab_image_content) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        if ($request->hasFile('image')) {
            $rules['image'] = 'mimes:jpg,jpeg,png,gif|max:20480';
            $messages['image.mimes'] = __('image_mimes');
            $messages['image.max'] = __('image_max');
        }
        $rules['section_type'] = 'nullable|string|max:50';
        $messages['section_type.string'] = __('section_type_string');
        $messages['section_type.max'] = __('section_type_max', ['max' => 50]);

        $validatedData = $request->validate($rules, $messages);

        try {
            if ($request->has('delete_image') && $tab_image_content->image) {
                if (File::exists(public_path($tab_image_content->image))) {
                    File::delete(public_path($tab_image_content->image));
                }
                $tab_image_content->image = null;
            }

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/content/' . $folderName), $fileName);
                    $image_path = 'uploads/images/content/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }

                $backupImage = $tab_image_content->image;
                $tab_image_content->image = $image_path;
            }

            $translateTitle = [];
            $translateContent = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateContent[$locale] = $request->get("content_{$locale}");
            }

            $tab_image_content->setTranslations('title', $translateTitle);
            $tab_image_content->setTranslations('content', $translateContent);
            $tab_image_content->save();

            if (isset($backupImage) && File::exists(public_path($backupImage))) {
                File::delete(public_path($backupImage));
            }

            return redirect()->route('tabs-programs.component1pp', $tab_image_content->tab_id)->with('success', __('update_success'));

        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('update_error') . $e->getMessage()])->withInput();
        }
    }

    public function destroyContentComponent1PP($tab_id, $id)
    {
        $tab = Tab::findOrFail($tab_id);
        if (!$tab) {
            return back()->with('error', __('no_find_data'));
        }
        try {
            $tab_drop_content = TabImgContent::findOrFail($id);
            if ($tab_drop_content->image && File::exists(public_path($tab_drop_content->image))) {
                File::delete(public_path($tab_drop_content->image));
            }
            $tab_drop_content->delete();
            return redirect()->route('show_content', $tab_id)->with('success', __('delete_tab_success'));
        } catch (\Exception $e) {
            return redirect()->route('show_content', $tab_id)->with('error', __('delete_tab_error'));
        }
    }



    public function showComponent2PP($id)
    {
        $tab = Tab::findOrFail($id);
        $tab_drops = TabDrop::where('tab_id', $tab->id)->get();

        // if ($tab_drops->isEmpty()) {
        //     return redirect()->back()->with('error', __('no_content_found'));
        // }

        $languages = Language::all();
        return view('admin.pages.tab_chuongtrinh.show_program_pp.show_drop_content', compact('tab', 'tab_drops', 'languages'));
    }

    public function createComponent2PP($id)
    {
        $tab = Tab::find($id);
        if (!$tab || $tab->slug != 'phat-trien-cac-du-an-mini') {
            return back()->with('error', __('no_find_data'));
        }

        $languages = Language::all();
        return view('admin.pages.tab_chuongtrinh.show_program_pp.create_drop_content', compact('tab','languages'));
    }

    public function storeComponent2PP(Request $request,$id)
    {
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

        $rules['icon'] = 'nullable|string|max:255';
        $rules['bg_color'] = 'nullable|string|max:255';
        $rules['image'] = 'nullable|mimes:jpg,jpeg,png,gif|max:20480';

        $messages['icon.string'] = __('icon_string');
        $messages['icon.max'] = __('icon_max', ['max' => 255]);
        $messages['bg_color.string'] = __('bg_color_string');
        $messages['bg_color.max'] = __('bg_color_max', ['max' => 255]);
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
            $tab_drop_content->icon = $request->input('icon');
            $tab_drop_content->bg_color = $request->input('bg_color');
            $tab_drop_content->tab_id = $id;
            $tab_drop_content->save();


            return redirect()->route('tabs-programs.component2pp', $id)->with('success', __('drop_success'));

        } catch (\Exception $e) {
            if (isset($tab_drop_content->image) && File::exists(public_path($tab_drop_content->image))) {
                File::delete(public_path($tab_drop_content->image));
            }
            return back()->with(['error' => __('store_error') . $e->getMessage()])->withInput();
        }
    }

    public function editComponent2PP($id)
    {
        $tab_drop_content = TabDrop::where('id', $id)->first();
        $languages = Language::all();

        if (!$tab_drop_content) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

        return view('admin.pages.tab_chuongtrinh.show_program_pp.edit_drop_content', compact('tab_drop_content', 'languages'));
    }

    public function updateComponent2PP(Request $request, $id)
    {
        $tab_drop_content = TabDrop::findOrFail($id);

        if (!$tab_drop_content) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $rules['icon'] = 'nullable|string';
        $rules['bg_color'] = 'nullable|string|max:255';

        $messages['icon.string'] = __('icon_string');
        $messages['bg_color.string'] = __('bg_color_string');
        $messages['bg_color.max'] = __('bg_color_max', ['max' => 255]);

        if ($request->hasFile('image')) {
            $rules['image'] = 'mimes:jpg,jpeg,png,gif|max:20480';
            $messages['image.mimes'] = __('image_mimes');
            $messages['image.max'] = __('image_max');
        }

        $validatedData = $request->validate($rules, $messages);

        try {

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/content/' . $folderName), $fileName);
                    $image_path = 'uploads/images/content/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }

                $backupImage = $tab_drop_content->image;
                $tab_drop_content->image = $image_path;
            }

            $translateTitle = [];
            $translateContent = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateContent[$locale] = $request->get("content_{$locale}");
            }

            $tab_drop_content->setTranslations('title', $translateTitle);
            $tab_drop_content->setTranslations('content', $translateContent);
            $tab_drop_content->icon = $request->input('icon');
            $tab_drop_content->bg_color = $request->input('bg_color');
            $tab_drop_content->save();

            if (isset($backupImage) && File::exists(public_path($backupImage))) {
                File::delete(public_path($backupImage));
            }

            return redirect()->route('tabs-programs.component2pp', $tab_drop_content->tab_id)->with('success', __('update_success'));

        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('update_error') . $e->getMessage()])->withInput();
        }
    }

    public function destroyComponent2PP($tab_id, $id)
    {
        $tab = Tab::findOrFail($tab_id);
        if (!$tab) {
            return back()->with('error', __('tab_program_not_found'));
        }
        try {
            $tab_drop_content = TabDrop::findOrFail($id);
            if ($tab_drop_content->image && File::exists(public_path($tab_drop_content->image))) {
                File::delete(public_path($tab_drop_content->image));
            }
            $tab_drop_content->delete();
            return redirect()->route('tabs-programs.component2pp', $tab_id)->with('success', __('delete_tab_drop_success'));
        } catch (\Exception $e) {
            return redirect()->route('tabs-programs.component2pp', $tab_id)->with('error', __('delete_tab_drop_error'));
        }
    }





    public function showComponent3PP($id)
    {
        $tab = Tab::findOrFail($id);
        $tab_projects = TabProject::where('tab_id', $tab->id)->get();

        // if ($tab_projects->isEmpty()) {
        //     return redirect()->back()->with('error', __('no_content_found'));
        // }

        $languages = Language::all();
        return view('admin.pages.tab_chuongtrinh.show_program_pp.show_project', compact('tab', 'tab_projects', 'languages'));
    }

    public function createComponent3PP($id)
    {
        $tab = Tab::find($id);
        if (!$tab || $tab->slug != 'phat-trien-cac-du-an-mini') {
            return back()->with('error', __('no_find_data'));
        }

        $languages = Language::all();
        return view('admin.pages.tab_chuongtrinh.show_program_pp.create_project', compact('tab','languages'));
    }

    public function storeComponent3PP(Request $request,$id)
    {
        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {

            $rules["project_name_{$locale}"] = 'required|string';
            $rules["content_{$locale}"] = 'nullable|string';
            $messages["project_name_{$locale}.required"] = __('content_required');
            $messages["project_name_{$locale}.string"] = __('content_string');
        }

        $rules['date'] = 'required|string';
        $rules['type'] = 'required|string';
        $rules['image'] = 'nullable|mimes:jpg,jpeg,png,gif|max:20480';

        $messages['image.mimes'] = __('image_mimes');
        $messages['image.max'] = __('image_max');

        $validatedData = $request->validate($rules, $messages);

        try {
            $tab_projects = new TabProject();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/content/' . $folderName), $fileName);
                $tab_projects->image = 'uploads/images/content/' . $folderName . '/' . $fileName;
            }

            $translateContent = [];
            $translateDesc = [];

            foreach ($locales as $locale) {
                $translateContent[$locale] = $request->get("project_name_{$locale}");
                $translateDesc[$locale] = $request->get("content_{$locale}");
            }
            $slug = Str::slug($translateContent[config('app.locale')]);
            if (TabProject::where('slug', $slug)->exists()) {
                return redirect()->back()->with('error', __('slug_exists'));
            }
            if (empty($tab_projects['content']['en']) && empty($tab_projects['content']['vi'])) {
                $tab_projects['content'] = null;
            }
            $tab_projects->setTranslations('project_name', $translateContent);
            $tab_projects->setTranslations('content', $translateDesc);
            $tab_projects->date = $request->input('date');
            $tab_projects->type = $request->input('type');
            $tab_projects->slug = $slug;
            $tab_projects->tab_id = $id;
            $tab_projects->save();


            return redirect()->route('tabs-programs.component3pp', $id)->with('success', __('create_success'));

        } catch (\Exception $e) {
            if (isset($tab_projects->image) && File::exists(public_path($tab_projects->image))) {
                File::delete(public_path($tab_projects->image));
            }
            return back()->with(['error' => __('create_error') . $e->getMessage()])->withInput();
        }
    }

    public function editComponent3PP($id)
    {
        $tab_projects = TabProject::where('id', $id)->first();
        $languages = Language::all();

        if (!$tab_projects) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

        return view('admin.pages.tab_chuongtrinh.show_program_pp.edit_project', compact('tab_projects', 'languages'));
    }

    public function updateComponent3PP(Request $request, $id)
    {
        $tab_projects = TabProject::findOrFail($id);

        if (!$tab_projects) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {
            $rules["project_name_{$locale}"] = 'required|string';
            $rules["content_{$locale}"] = 'nullable|string';
            $messages["project_name_{$locale}.required"] = __('content_required');
            $messages["project_name_{$locale}.string"] = __('content_string');
        }

        $rules['date'] = 'required|string';
        $rules['type'] = 'required|string';


        if ($request->hasFile('image')) {
            $rules['image'] = 'nullable|mimes:jpg,jpeg,png,gif|max:20480';
            $messages['image.mimes'] = __('image_mimes');
            $messages['image.max'] = __('image_max');
        }

        $validatedData = $request->validate($rules, $messages);

        try {

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/content/' . $folderName), $fileName);
                    $image_path = 'uploads/images/content/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }

                $backupImage = $tab_projects->image;
                $tab_projects->image = $image_path;
            }

            $translateTitle = [];
            $translateContent = [];
            $translateDesc = [];

            foreach ($locales as $locale) {

                $translateContent[$locale] = $request->get("project_name_{$locale}");
                $contentValue = $request->get("content_{$locale}");
                if (!is_null($contentValue) && $contentValue !== '') {
                    $translateDesc[$locale] = $contentValue;
                }

                
            }
          
            $tab_projects->setTranslations('project_name', $translateContent);
            $tab_projects->content = $translateDesc;
            $tab_projects->date = $request->input('date');
            $tab_projects->type = $request->input('type');
            $tab_projects->save();

            if (isset($backupImage) && File::exists(public_path($backupImage))) {
                File::delete(public_path($backupImage));
            }

            return redirect()->route('tabs-programs.component3pp', $tab_projects->tab_id)->with('success', __('update_success'));

        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('update_error') . $e->getMessage()])->withInput();
        }
    }

    public function destroyComponent3PP($tab_id, $id)
    {
        $tab = Tab::findOrFail($tab_id);
        if (!$tab) {
            return back()->with('error', __('tab_program_not_found'));
        }
        try {
            $tab_projects = TabProject::findOrFail($id);
            if ($tab_projects->image && File::exists(public_path($tab_projects->image))) {
                File::delete(public_path($tab_projects->image));
            }
            $tab_projects->delete();
            return redirect()->route('tabs-programs.component3pp', $tab_id)->with('success', __('delete_tab_success'));
        } catch (\Exception $e) {
            return redirect()->route('tabs-programs.component3pp', $tab_id)->with('error', __('delete_tab_error'));
        }
    }





    public function showComponent3PPDetail($id)
    {
        $tab_projects = TabProject::findOrFail($id);
        $mediaItems = TabProjectImage::where('tab_project_id', $id)->get();
        // if ($mediaItem->isEmpty()) {
        //     abort(404);
        // }
        return view('admin.pages.tab_chuongtrinh.show_program_pp.show_detail_project.show_project_detail', compact('mediaItems','tab_projects'));
    }

    public function createComponent3PPDetail($id)
    {
        $tabContent = TabProject::findOrFail($id);
        return view('admin.pages.tab_chuongtrinh.show_program_pp.show_detail_project.create_project_detail', compact('tabContent'));
    }
    public function storeComponent3PPDetail(Request $request, $id)
    {
        $rules = [
            'files.*' => 'required|mimes:jpg,png,jpeg|max:20480',
        ];

        $messages = [
            'files.*.required' => __('file_required'),
            'files.*.mimes' => __('file_mimes'),
            'files.*.max' => __('file_max'),
        ];

        $request->validate($rules, $messages);

        $invalidFiles = [];
        $filePaths = [];

        try {
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    try {
                        $extension = $file->getClientOriginalExtension();

                        if (!in_array($extension, ['jpg', 'png', 'jpeg'])) {
                            $invalidFiles[] = $file->getClientOriginalName();
                        }

                        $folderName = date('Y/m');
                        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $fileName = $originalFileName . '_' . time() . '.' . $extension;

                        $file->move(public_path('/uploads/media/' . $folderName), $fileName);
                        $filePath = 'uploads/media/' . $folderName . '/' . $fileName;
                        $filePaths[] = $filePath;

                    } catch (\Exception $e) {
                        foreach ($filePaths as $path) {
                            if (File::exists(public_path($path))) {
                                File::delete(public_path($path));
                            }
                        }
                        return back()->withInput()->with('error', __('upload_media_error'));
                    }
                }
            }

            if (!empty($invalidFiles)) {
                return back()->withErrors([
                    'files' => __('file_mimes_invalid', [
                        'files' => implode(', ', $invalidFiles),
                    ])
                ])->withInput();
            }

            foreach ($filePaths as $filePath) {
                $mediaItem = new TabProjectImage();
                $mediaItem->tab_project_id = $id;
                $mediaItem->image = $filePath;
                $mediaItem->save();
            }

            return redirect()->route('tabs-programs.component3pp.show.detail', $id)->with('success', __('create_success'));

        } catch (\Exception $e) {
            foreach ($filePaths as $path) {
                if (File::exists(public_path($path))) {
                    File::delete(public_path($path));
                }
            }
            return back()->with(['error' => __('update_content_error')])->withInput();
        }
    }

    public function editComponent3PPDetail($tab_id, $detail_id)
    {
        $mediaItem = TabProjectImage::findOrFail($detail_id);
        if (!$mediaItem) {
            return back()->with('error', __('no_find_data'));
        }
        return view('admin.pages.tab_chuongtrinh.show_program_pp.show_detail_project.edit_project_detail', compact('mediaItem'));
    }

    public function updateComponent3PPDetail(Request $request, $tab_id, $detail_id)
    {
        $mediaItem = TabProjectImage::findOrFail($detail_id);

        $rules = [
            'file' => 'nullable|mimes:jpg,png,jpeg|max:20480',
        ];

        $messages = [
            'file.mimes' => __('file_mimes'),
            'file.max' => __('file_max'),
        ];

        $request->validate($rules, $messages);
        $filePath = $mediaItem->image;

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                if (!in_array($extension, ['jpg', 'png', 'jpeg'])) {
                    return back()->with(['error' => __('file_mimes_invalid')])->withInput();
                }
                if ($mediaItem->image && File::exists(public_path($mediaItem->image))) {
                    File::delete(public_path($mediaItem->image));
                }
                $folderName = date('Y/m');
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $file->move(public_path('/uploads/media/' . $folderName), $fileName);
                $filePath = 'uploads/media/' . $folderName . '/' . $fileName;
            }


            $mediaItem->image = $filePath;
            $mediaItem->save();

            return redirect()->route('tabs-programs.component3pp.show.detail', $tab_id)
                ->with('success', __('update_success'));
        } catch (\Exception $e) {

            if (isset($filePath) && File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }
            return back()->with(['error' => __('update_content_tab_error')])->withInput();
        }
    }

    public function destroyComponent3PPDetail($tab_id, $detail_id)
    {
        try {

            $mediaItem = TabProjectImage::findOrFail($detail_id);

            if ($mediaItem->image && File::exists(public_path($mediaItem->image))) {
                File::delete(public_path($mediaItem->image));
            }

            $mediaItem->delete();
            return redirect()->route('tabs-programs.component3pp.show.detail', $tab_id)->with('success', __('delete_success'));
        } catch (\Exception $e) {
            return back()->with(['error' => __('delete_error') . $e->getMessage()]);
        }

    }





    public function showComponent2($id)
    {
        $tab = Tab::findOrFail($id);
        $tab_drops = TabDrop::where('tab_id', $tab->id)->get();

        if ($tab_drops->isEmpty()) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

        $languages = Language::all();
        return view('admin.pages.tab_chuongtrinh.show_program.show_drop_content', compact('tab', 'tab_drops', 'languages'));
    }


    public function editComponent1($id)
    {
        $tab_image_content = TabImgContent::where('id', $id)->first();
        $languages = Language::all();

        if (!$tab_image_content) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

        return view('admin.pages.tab_chuongtrinh.show_program.edit_img_content', compact('tab_image_content', 'languages'));
    }
    public function editComponent2($id)
    {
        $tab_drop_content = TabDrop::where('id', $id)->first();
        $languages = Language::all();

        if (!$tab_drop_content) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

        return view('admin.pages.tab_chuongtrinh.show_program.edit_drop_content', compact('tab_drop_content', 'languages'));
    }


    public function updateComponent1(Request $request, $id)
    {
        $tab_image_content = TabImgContent::findOrFail($id);

        if (!$tab_image_content) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        if ($request->hasFile('image')) {
            $rules['image'] = 'mimes:jpg,jpeg,png,gif|max:20480';
            $messages['image.mimes'] = __('image_mimes');
            $messages['image.max'] = __('image_max');
        }

        $validatedData = $request->validate($rules, $messages);

        try {
            if ($request->has('delete_image') && $tab_image_content->image) {
                if (File::exists(public_path($tab_image_content->image))) {
                    File::delete(public_path($tab_image_content->image));
                }
                $tab_image_content->image = null;
            }

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/content/' . $folderName), $fileName);
                    $image_path = 'uploads/images/content/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }

                $backupImage = $tab_image_content->image;
                $tab_image_content->image = $image_path;
            }

            $translateTitle = [];
            $translateContent = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateContent[$locale] = $request->get("content_{$locale}");
            }

            $tab_image_content->setTranslations('title', $translateTitle);
            $tab_image_content->setTranslations('content', $translateContent);
            $tab_image_content->save();

            if (isset($backupImage) && File::exists(public_path($backupImage))) {
                File::delete(public_path($backupImage));
            }

            return redirect()->route('tabs-programs.component1', $tab_image_content->tab_id)->with('success', __('update_success'));

        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('update_error') . $e->getMessage()])->withInput();
        }
    }
    public function updateComponent2(Request $request, $id)
    {
        $tab_drop_content = TabDrop::findOrFail($id);

        if (!$tab_drop_content) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $rules['icon'] = 'nullable|string';
        $rules['bg_color'] = 'nullable|string|max:255';

        $messages['icon.string'] = __('icon_string');
        $messages['bg_color.string'] = __('bg_color_string');
        $messages['bg_color.max'] = __('bg_color_max', ['max' => 255]);

        if ($request->hasFile('image')) {
            $rules['image'] = 'mimes:jpg,jpeg,png,gif|max:20480';
            $messages['image.mimes'] = __('image_mimes');
            $messages['image.max'] = __('image_max');
        }

        $validatedData = $request->validate($rules, $messages);

        try {

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/content/' . $folderName), $fileName);
                    $image_path = 'uploads/images/content/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }

                $backupImage = $tab_drop_content->image;
                $tab_drop_content->image = $image_path;
            }

            $translateTitle = [];
            $translateContent = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateContent[$locale] = $request->get("content_{$locale}");
            }

            $tab_drop_content->setTranslations('title', $translateTitle);
            $tab_drop_content->setTranslations('content', $translateContent);
            $tab_drop_content->icon = $request->input('icon');
            $tab_drop_content->bg_color = $request->input('bg_color');
            $tab_drop_content->save();

            if (isset($backupImage) && File::exists(public_path($backupImage))) {
                File::delete(public_path($backupImage));
            }

            return redirect()->route('tabs-programs.component2', $tab_drop_content->tab_id)->with('success', __('update_success'));

        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('update_error') . $e->getMessage()])->withInput();
        }
    }

    public function destroyComponent2($tab_id, $id)
    {
        $tab = Tab::findOrFail($tab_id);
        if (!$tab) {
            return back()->with('error', __('tab_program_not_found'));
        }
        try {
            $tab_drop_content = TabDrop::findOrFail($id);
            if ($tab_drop_content->image && File::exists(public_path($tab_drop_content->image))) {
                File::delete(public_path($tab_drop_content->image));
            }
            $tab_drop_content->delete();
            return redirect()->route('tabs-programs.component2', $tab_id)->with('success', __('delete_tab_drop_success'));
        } catch (\Exception $e) {
            return redirect()->route('tabs-programs.component2', $tab_id)->with('error', __('delete_tab_drop_error'));
        }
    }


    public function showDetailTab($id){
        if (!is_numeric($id)) {
            abort(404);
        }

        $project = TabProject::with('images')->find($id);

        if (!$project) {
            abort(404);
        }

        return view('pages.detail-dev-project', compact('project'));
    }

    public function showPageAll(){

        $showPage = Tab::get();
        return view('admin.pages.all_page.index', compact('showPage'));
    }

    public function showPageEdit($id){
        $page = Tab::find($id);
        if(!$page){
            return back()->with('error', __('no_content_found'));
        }
        return view('admin.pages.all_page.edit', compact('page'));

    }
    public function showPageUpdate(Request $request, $id)
    {
        $page = Tab::find($id);

        if(!$page){
            return back()->with('error', __('no_content_found'));
        }

        $rules = [
            'active' => 'required|in:yes,no',
        ];

        $messages = [
            'active.required' => __('form.active.required'),
            'active.in' => __('form.active.in'),
        ];

        $request->validate($rules, $messages);

        $page->active = $request->input('active');
        $page->save();

        return redirect()->route('show.page.all')->with('success', __('update_success'));
    }



}
