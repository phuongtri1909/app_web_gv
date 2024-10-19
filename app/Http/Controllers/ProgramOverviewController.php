<?php

namespace App\Http\Controllers;

use App\Models\TabCustom;
use App\Models\TabDrop;
use App\Models\TabImgContent;
use App\Models\TabProject;
use Exception;
use App\Models\ProgramOverview;
use App\Models\CategoryProgram;
use App\Models\Language;
use App\Models\Slider;
use App\Models\Tab;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProgramOverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index($category_id)
    {
        $programs = ProgramOverview::where('category_id', $category_id)->get();
        $category = CategoryProgram::find($category_id);

        return view('admin.pages.overview_program.index', compact('programs', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        $categories = CategoryProgram::all();
        return view('admin.pages.overview_program.create', compact('categories' , 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = CategoryProgram::find($request->input('category_id'));
        if (!$category) {
            return redirect()->route('programs.index')->with('error', __('category_not_found'));
        }
        $locales = Language::pluck('locale')->toArray();

        $messages = [
            'category_id.required' => __('form.category_id.required'),
            'category_id.exists' => __('form.category_id.exists'),

            'img_program.required' => __('form.img_program.required'),
            'img_program.image' => __('form.img_program.image'),
        ];

        if($category->key_page == 'key_cb2')
        {
            $rules = [
                'rank' => 'required|integer|min:1',
            ];
            $messages['rank.required'] = __('form.rank.required');
            $messages['rank.integer'] = __('form.rank.integer');
            $messages['rank.min'] = __('form.rank.min');
            $messages['rank.unique'] = __('form.rank.unique');
        }


        foreach ($locales as $locale) {
            $rules["title_program-{$locale}"] = 'required|string';
            $rules["short_description-{$locale}"] = 'nullable|string';
            $rules["long_description-{$locale}"] = 'required|string';

            if ($category && $category->key_page == 'key_cb2') {
                $rules['img_program'] = 'nullable|image';
            } else {
                $rules['img_program'] = 'required|image';
            }

            $messages["title_program-{$locale}.required"] = __('form.title_program.locale.required', ['locale' => $locale]);
            $messages["long_description-{$locale}.required"] = __('form.long_description.locale.required', ['locale' => $locale]);
            $messages["short_description-{$locale}.string"] = __('form.short_description.locale.string', ['locale' => $locale]);
            $messages["long_description-*.string"] = __('form.long_description.locale.string', ['locale' => $locale]);
            $messages["title_program-*.string"] = __('form.title_program.locale.string', ['locale' => $locale]);
        }
        $request->validate($rules, $messages);

        try {
            try {
                $programImagePath = null;
                if ($request->hasFile('img_program')) {
                    $programImage = $request->file('img_program');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($programImage->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $programImage->getClientOriginalExtension();
                    $programImageName = $originalFileName . '_' . time() . '.' . $extension;
                    $programImage->move(public_path('uploads/images/programs/' . $folderName), $programImageName);
                    $programImagePath = 'uploads/images/programs/' . $folderName . '/' . $programImageName;
                }
            } catch (Exception $e) {
                if (isset($programImagePath) && File::exists(public_path($programImagePath))) {
                    File::delete(public_path($programImagePath));
                }
                return back()->withInput()->with('error', '[E15] ' . __('form.image_url.required'));
            }

            $ov_pro = new ProgramOverview();
            $translationsTitleProgram = [];
            $translationsShortDesc = [];
            $translationsLongDesc = [];
            foreach ($locales as $locale) {
                $translationsTitleProgram[$locale] = $request->input("title_program-{$locale}");
                $translationsShortDesc[$locale] = $request->input("short_description-{$locale}");
                $translationsLongDesc[$locale] = $request->input("long_description-{$locale}");
            }

            $translationsTitleProgram[$request->locale] = $request->input('title_program');
            $translationsShortDesc[$request->locale] = $request->input('short_description');
            $translationsLongDesc[$request->locale] = $request->input('long_description');

            $ov_pro->setTranslations('title_program', $translationsTitleProgram);
            $ov_pro->setTranslations('short_description', $translationsShortDesc);
            $ov_pro->setTranslations('long_description', $translationsLongDesc);
            $ov_pro->img_program = $programImagePath;
            $ov_pro->category_id = $request->category_id;
            if($category->key_page == 'key_cb2')
            {
                $ov_pro->rank = $request->rank;
            }
            $ov_pro->save();

        } catch (QueryException $e) {
            if (isset($programImagePath) && File::exists(public_path($programImagePath))) {
                File::delete(public_path($programImagePath));
            }
            return back()->withInput()->with('error', '[E16] ' . __('overview_program_create_error_db.').$e->getMessage());
        }catch (Exception $e) {
            if (isset($programImagePath) && File::exists(public_path($programImagePath))) {
                File::delete(public_path($programImagePath));
            }
            return back()->withInput()->with('error', '[E17] ' . __('create_new_overview_program_error') . $e->getMessage());

        }
        return redirect()->route('overviewprograms.index',$request->category_id)->with('success', __('create_overview_program_success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $languages = Language::all();
        $programs = ProgramOverview::find($id);
        if (!$programs) {
            return redirect()->route('overview_program.index')->with('error', __('program_not_found'));
        }

        $categories = CategoryProgram::all();
        return view('admin.pages.overview_program.edit', compact('programs', 'categories','languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $program = ProgramOverview::find($id);
        $locales = Language::pluck('locale')->toArray();
        if (!$program) {
            return redirect()->route('programs.index')->with('error', '[E19] ' . __('program_not_found'));
        }
        else
        {
            $category = CategoryProgram::find($request->input('category_id'));
            if (!$category) {
                return redirect()->route('programs.index')->with('error', __('category_not_found'));
            }
            $rules = [
                'category_id' => 'required|exists:categories_program,id',
            ];

            // Validation messages
            $messages = [
                'category_id.required' => __('form.category_id.required'),
                'category_id.exists' => __('form.category_id.exists'),
            ];

            if($category->key_page == 'key_cb2')
            {
                $rules['rank'] = 'required|integer|min:1';
                $messages['rank.required'] = __('form.rank.required');
                $messages['rank.integer'] = __('form.rank.integer');
                $messages['rank.min'] = __('form.rank.min');
                $messages['rank.unique'] = __('form.rank.unique');
            }

            foreach ($locales as $locale) {
                $rules["title_program-{$locale}"] = 'required|string';
                $rules["short_description-{$locale}"] = 'nullable|string';
                $rules["long_description-{$locale}"] = 'required|string';

                $messages["title_program-{$locale}.required"] = __('form.title_program.locale.required', ['locale' => $locale]);
                $messages["long_description-{$locale}.required"] = __('form.long_description.locale.required', ['locale' => $locale]);
                $messages["short_description-{$locale}.nullable"] = __('form.short_description.locale.nullable', ['locale' => $locale]);
                $messages["short_description-{$locale}.string"] = __('form.short_description.locale.string', ['locale' => $locale]);
            }
            if ($request->file('img_program')) {
                if ($category && $category->key_page == 'key_cp2') {
                    $rules['img_program'] = 'nullable|image';
                } else {
                    $rules['img_program'] = 'required|image';
                }

                $messages['img_program.required'] = __('form.img_program.required');
                $messages['img_program.image'] = __('form.img_program.image');
            }
            // Validate the request data
            $validatedData = $request->validate($rules, $messages);

            try {
                // Handle image upload
                if ($request->hasFile('img_program')) {

                    if (File::exists(public_path($program->img_program))) {
                        File::delete(public_path($program->img_program));
                    }

                    // Store the new image
                    $imgFile = $request->file('img_program');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $imgFile->getClientOriginalExtension();
                    $imgFileName = $originalFileName . '_' . time() . '.' . $extension;
                    $imgFilePath = 'uploads/images/programs/' . $folderName . '/' . $imgFileName;
                    $imgFile->move(public_path('uploads/images/programs/' . $folderName), $imgFileName);

                    $validatedData['img_program'] = $imgFilePath;
                } else {
                    // Keep the old image path if no new image is uploaded
                    $validatedData['img_program'] = $program->img_program;
                }
                $translationsTitleProgram = [];
                $translationsShortDesc = [];
                $translationsLongDesc = [];
                foreach ($locales as $locale) {
                    $translationsTitleProgram[$locale] = $request->input("title_program-{$locale}");
                    $translationsShortDesc[$locale] = $request->input("short_description-{$locale}");
                    $translationsLongDesc[$locale] = $request->input("long_description-{$locale}");
                }

                $translationsTitleProgram[$request->locale] = $request->input('title_program');
                $translationsShortDesc[$request->locale] = $request->input('short_description');
                $translationsLongDesc[$request->locale] = $request->input('long_description');

                $program->setTranslations('title_program', $translationsTitleProgram);
                $program->setTranslations('short_description', $translationsShortDesc);
                $program->setTranslations('long_description', $translationsLongDesc);
                $program->category_id = $request->category_id;
                if($category->key_page == 'key_cb2')
                {
                    $program->rank = $request->rank;
                }
                // Update the program overview
                $program->update($validatedData);

            } catch (QueryException $e) {
                return back()->withInput()->with('error', '[E16] ' . __('programs_update_error_db'));
            } catch (Exception $e) {
                return back()->withInput()->with('error', '[E17] ' . __('update_new_programs_error'));
            }

            return redirect()->route('overviewprograms.index',$request->category_id)->with('success', __('form_update_programs_success'));
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Tìm bản ghi
        $program = ProgramOverview::find($id);
        $category_id = $program->category_id;
        if (!$program) {
            return redirect()->route('overviewprograms.index', $category_id)
                             ->with('error', __('program_not_found'));
        }

        try {
            $program->delete();
            return redirect()->route('overviewprograms.index', $category_id)
                             ->with('success', __('delete_program_success'));
        } catch (QueryException $e) {
            // Xử lý lỗi khi xóa
            return back()->with('error', __('program_delete_error_db'));
        } catch (\Exception $e) {
            return back()->with('error', __('delete_program_error'));
        }
    }

    public function pagePrograms($slug)
    {

        $view = null;
        $tab = Tab::where('slug', $slug)->first();
        switch ($slug) {
            case 'phuong-phap-giao-duc':
                $view = 'pages.pedagogical-method';

                $tab = Tab::where('slug','phuong-phap-giao-duc')->first();
                break;
            case 'phat-trien-cac-du-an-mini':
                $view = 'pages.dev-mini';

                $tab = Tab::where('slug', 'phat-trien-cac-du-an-mini')->first();
                break;
            case 'programs-content':
                $category_page_program = CategoryProgram::where('key_page', 'page_program')->first();
                $programs_page_program = $category_page_program->programs ?? null;

                $category_key_cb2 = CategoryProgram::where('key_page', 'key_cb2')->first();
                $programs_cp2 = $category_key_cb2 ? $category_key_cb2->programs()->orderBy('rank', 'asc')->get() : null;

                $sliders = Slider::where('active', 'yes')->where('key_page', 'key_program')->get();
                $tab = Tab::where('slug','programs-content')->first();
                return view('pages.program', compact('category_page_program', 'programs_page_program', 'programs_cp2', 'sliders', 'tab'));
                default:
            if ($tab) {
                $component_2 = $tab->imgContents->where('section_type','component_1')->first();

                $components_3 = $tab->imgContents()->where('section_type','component_2')->get();

                return view('pages.tab-custom.index', compact('tab','component_2','components_3'));
            }
            break;
        }

        if ($view && $tab) {
            $customs = TabCustom::where('tab_id', $tab->id)->first();
            $drops = TabDrop::where('tab_id', $tab->id)->get();
            $imgContents = TabImgContent::where('tab_id', $tab->id)->get();
            $imgContents_dev = TabImgContent::where('tab_id', $tab->id)
                                        ->take(1)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
            $projectsLeft = TabProject::where('tab_id', $tab->id)
                                        ->where('type', 'left')
                                        ->orderBy('date', 'desc')
                                        ->take(1)
                                        ->get();
            $projectsRight = TabProject::where('tab_id', $tab->id)
                                        ->where('type', 'right')
                                        ->orderBy('date', 'desc')
                                        ->take(2)
                                        ->get();
            $tabProject = TabProject::where('tab_id', $tab->id)->whereRaw('content IS NULL OR content = ?', [json_encode([])])->get();
            return view($view, compact('tab', 'customs', 'drops', 'imgContents', 'projectsLeft', 'projectsRight','tabProject','imgContents_dev'));
        }
    }
}
