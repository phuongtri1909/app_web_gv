<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Language;
use App\Models\Paper;
use App\Models\ParentsChild;
use App\Models\ParentsChildDetail;
use App\Models\Tab;
use App\Models\TabImgContent;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TabsForParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tabs_parents = Tab::where('key_page', 'parent')->get();
        return view('admin.pages.tab_parent.index', compact('tabs_parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.tab_parent.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
            $rules["title_{$locale}"] = 'string|max:255';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
        }

        $slug = Str::slug($request->title_en);


        if (Tab::where('slug', $slug)->exists()) {
            return back()->with('error', __('slug_exists'));
        }

        $validatedData = $request->validate($rules, $messages);


        try {
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
            $tab->key_page = 'parent';
            $tab->banner = $image_path;
            $tab->save();
            return redirect()->route('tabs-parents.index')->with('success', __('create_tab_parent_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('create_tab_parent_error')])->withInput();
        }
    }


    public function createContent($id)
    {

        $tab = Tab::find($id);
        if (!$tab) {
            return back()->with('error', __('no_find_data'));
        }
        $languages = Language::all();
        return view('admin.pages.tab_parent.create_content', compact('tab', 'languages'));
    }

    public function storeContent(Request $request, $tab_id)
    {
        $tab = Tab::findOrFail($tab_id);

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

        try {
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
            $tab_content->save();
            return redirect()->route('tabs-parents.show', $tab->id)->with('success', __('create_content_tab_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('create_content_tab_error')])->withInput();
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tab = Tab::findOrFail($id);
        $languages = Language::all();

        if ($tab->key_page != 'parent') {
            return redirect()->route('tabs-parents.index')->with('error', __('tab_parent_not_found'));
        }
        $tab_image_content = TabImgContent::where('tab_id', $tab->id)->get();

        return view('admin.pages.tab_parent.show_content', compact('tab', 'tab_image_content', 'languages'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function editContent($id)
    {
        $tab_content = TabImgContent::where('id', $id)->first();
        if (!$tab_content) {
            return back()->with('error', __('no_content_found'));
        }

        $languages = Language::all();
        return view('admin.pages.tab_parent.edit_content', compact('tab_content', 'languages'));
    }


    public function updateContent(Request $request, $id)
    {
        $tab_content = TabImgContent::where('id', $id)->firstOrFail();

        $locales = Language::pluck('locale')->toArray();

        $rules = [
            'image' => 'image|mimes:jpg,jpeg,png,gif',
        ];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'string';
        }

        $validatedData = $request->validate($rules);

        try {
            $translateTitle = [];
            $tranSlateContent = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $tranSlateContent[$locale] = $request->get("content_{$locale}");
            }

            if ($request->hasFile('image')) {

                if ($tab_content->image && File::exists(public_path($tab_content->image))) {
                    File::delete(public_path($tab_content->image));
                }

                $image = $request->file('image');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/tab_content/' . $folderName), $fileName);
                $image_path = 'uploads/images/tab_content/' . $folderName . '/' . $fileName;

                $tab_content->image = $image_path;
            }

            $tab_content->setTranslations('title', $translateTitle);
            $tab_content->setTranslations('content', $tranSlateContent);
            $tab_content->save();

            return redirect()->route('tabs-parents.show', $tab_content->tab_id)->with('success', __('update_content_tab_success'));
        } catch (\Exception $e) {
            return back()->with(['error' => __('update_content_tab_error')])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tab_image_content = TabImgContent::find($id);


            if (!$tab_image_content) {
                return back()->with('error', __('no_find_data'));
            }
            $tab_image_content->delete();

            return redirect()->route('tabs-parents.show', $tab_image_content->tab_id)->with('success', __('delete_success'));

        } catch (\Exception $e) {
            return back()->with(['error' => __('delete_error') . $e->getMessage()]);
        }
    }

    public function tabForParent(Request $request, $slug)
    {
        $tab = Tab::where('slug', $slug)->first();
        if (!$tab) {
            return abort(404);
        }
        $tab_img_content = TabImgContent::where('tab_id', $tab->id)->get();
        if (!$tab_img_content) {
            return view('pages.parents', compact('tab','tab_img_content'));
        }
        switch ($tab->slug) {
            case 'for-parent':
                $tab_img_content = TabImgContent::where('tab_id', $tab->id)->get();
                return view('pages.parents', compact('tab', 'tab_img_content'));
                break;
            case 'loi-ich-khi-con-hoc-tai-brighton-academy':
                $aboutUs = AboutUs::first();
                $cp1 = ParentsChild::where('component_type','type_cp1')->where('tab_id', $tab->id)->first();
                $cp2 = ParentsChild::where('component_type','type_cp2')->where('tab_id', $tab->id)->first();
                $cp3 = ParentsChild::where('component_type','type_cp3')->where('tab_id', $tab->id)->paginate(15, ['*'], 'page');
                return view('pages.parent.benefits', compact('tab','aboutUs','cp1','cp2','cp3'));
            case 'chien-luoc-va-meo':
                $testimonials = Testimonial::all();
                $papers = Paper::all();
                $cp1_c = ParentsChild::where('component_type','type_cp1')
                                    ->where('tab_id', $tab->id)->first();
                $cp2_c = ParentsChild::where('component_type','type_cp2')->where('tab_id', $tab->id)->paginate(15, ['*'], 'page');
                return view('pages.parent.strategies', compact('tab','testimonials','cp1_c','cp2_c','papers'));
            case 'cac-hoat-dong-va-su-kien-chung-toi':
                $cp1_ca = ParentsChild::where('component_type','type_cp1')
                                    ->where('tab_id', $tab->id)->first();
                $cp2_ca = ParentsChild::where('component_type','type_cp2')->where('tab_id', $tab->id)->paginate(15, ['*'], 'page');
                $cp3_ca = ParentsChild::where('component_type','type_cp3')->where('tab_id', $tab->id)->take(15)->get();
                return view('pages.parent.our-ctivities', compact('tab','cp1_ca','cp2_ca','cp3_ca'));
            default:
                return view('pages.parents', compact('tab', 'tab_img_content'));
                break;
        }
    }
    public function showForParent($slug){
        $blog = ParentsChild::where('slug', $slug)->firstOrFail();
        return view('pages.parent.detail-parent.show-detail', compact('blog'));
    }
    public function showDetailAlbum($id){
        if (!is_numeric($id)) {
            abort(404);
        }

        $project = ParentsChild::with('details')->find($id);

        if (!$project) {
            abort('404');
        }
        // dd($project);
        return view('pages.parent.detail-parent.show-album', compact('project'));
    }
}
