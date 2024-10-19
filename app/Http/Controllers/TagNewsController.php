<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\TagNews;
use Illuminate\Http\Request;

class TagNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = TagNews::all();
        return view('admin.pages.tag_blogs.index', compact('tags'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.tag_blogs.create', compact('languages'));
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

            $existingTags = TagNews::whereJsonContains('name', [$locale => $translatedName[$locale]])->first();

            if ($existingTags) {
                return back()->withInput()->withErrors([
                    "name_{$locale}" => __('name_tags') . ' ' . $translatedName[$locale] . ' ' . __('already_exists')
                ]);
            }
        }

        $tags = new TagNews();
        $tags->setTranslations('name', $translatedName);
        $tags->save();

        return redirect()->route('tags-news.index')->with('success', __('create_success'));
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
        $tags = TagNews::find($id);
        if (!$tags) {
            return back()->with('error', __('no_find_data'));
        }
        $languages = Language::all();

        return view('admin.pages.tag_blogs.edit', compact('tags', 'languages'));
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

        $tags = TagNews::findOrFail($id);

        $translatedName = [];
        foreach ($locales as $locale) {
            $translatedName[$locale] = $request->input("name_{$locale}");

            $existingTags= TagNews::where('id', '!=', $id)
                ->whereJsonContains('name', [$locale => $translatedName[$locale]])
                ->first();

            if ($existingTags) {
                return back()->withInput()->withErrors([
                    "name_{$locale}" => __('name_tags') . ' ' . $translatedName[$locale] . ' ' . __('already_exists')
                ]);
            }
        }

        $tags->setTranslations('name', $translatedName);
        $tags->save();

        return redirect()->route('tags-news.index')->with('success', __('update_success'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tags = TagNews::find($id);

        if (!$tags) {
            return redirect()->route('tags-news.index')->with('error', __('tags_news_not_found'));
        }

        // if ($news->published_at && $news->published_at <= now()) {
        //     return redirect()->route('news.index')->with('error', __('You cannot delete a published post.'));
        // }

        $tags->delete();

        return redirect()->route('tags-news.index')->with('success', __('tags_news_deleted_successfully'));
    }
}
