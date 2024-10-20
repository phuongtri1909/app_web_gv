<?php
namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\TabDetailPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TabDetailPostController extends Controller
{
    public function index()
    {
        $tabs = TabDetailPost::all();
        return view('admin.pages.blogs.tabs_detail_post.index', compact('tabs'));
    }

    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.blogs.tabs_detail_post.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {
            $rules["name_{$locale}"] = 'required|string|max:255';

            $messages["name_{$locale}.required"] = __('name_in') . strtoupper($locale) . __(' is_required.');
            $messages["name_{$locale}.string"] = __('name_string');
            $messages["name_{$locale}.max"] = __('name_max', ['max' => 255]);
        }

        $validatedData = $request->validate($rules, $messages);

        $translatedName = [];
        foreach ($locales as $locale) {
            $translatedName[$locale] = $request->input("name_{$locale}");

            $existingCategory = TabDetailPost::whereJsonContains('name', [$locale => $translatedName[$locale]])->first();
            if ($existingCategory) {
                return back()->withInput()->withErrors([
                    "name_{$locale}" => __('name_category') . ' ' . $translatedName[$locale] . ' ' . __('already_exists')
                ]);
            }
        }

        $category = new TabDetailPost();
        $category->setTranslations('name', $translatedName);
        $category->save();

        return redirect()->route('tabs_posts.index')->with('success', __('create_success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = TabDetailPost::findOrFail($id);

        $languages = Language::all();
        if (!$category) {
            return back()->with('error', __('no_find_data'));
        }
        return view('admin.pages.blogs.tabs_detail_post.edit', compact('category', 'languages'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {
            $rules["name_{$locale}"] = 'required|string|max:255';

            $messages["name_{$locale}.required"] = __('name_in') . strtoupper($locale) . __(' is_required.');
            $messages["name_{$locale}.string"] = __('name_string');
            $messages["name_{$locale}.max"] = __('name_max', ['max' => 255]);
        }

        $validatedData = $request->validate($rules, $messages);

        $category = TabDetailPost::findOrFail($id);

        $translatedName = [];
        foreach ($locales as $locale) {
            $translatedName[$locale] = $request->input("name_{$locale}");

            $existingCategory = TabDetailPost::where('id', '!=', $id)
                ->whereJsonContains('name', [$locale => $translatedName[$locale]])
                ->first();

            if ($existingCategory) {
                return back()->withInput()->withErrors([
                    "name_{$locale}" => __('name_category') . ' ' . $translatedName[$locale] . ' ' . __('already_exists')
                ]);
            }
        }
        // $slug = Str::slug($translatedName[config('app.locale')]);
        // if (CategoryNews::where('slug', $slug)->exists()) {
        //     return redirect()->back()->with('error', __('slug_exists'));
        // }

        // $category->slug = $slug;
        $category->setTranslations('name', $translatedName);
        $category->save();

        return redirect()->route('tabs_posts.index')->with('success', __('update_success'));
    }
    public function destroy($id)
    {
        $category = TabDetailPost::find($id);

        if (!$category) {
            return redirect()->route('tabs_posts.index')->with('error', __('content_not_found'));
        }


        $category->delete();

        return redirect()->route('tabs_posts.index')->with('success', __('delete_success'));
    }
}
