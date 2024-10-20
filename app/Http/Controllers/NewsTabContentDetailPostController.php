<?php
namespace App\Http\Controllers;

use App\Models\FinancialSupport;
use App\Models\Language;
use App\Models\NewsTabContentDetailPost;
use App\Models\TabDetailPost;
use App\Models\News;
use Illuminate\Http\Request;

class NewsTabContentDetailPostController extends Controller
{
    public function index()
    {
        $newsTabContentDetails = NewsTabContentDetailPost::with('financialSupport', 'tab')->get();

        return view('admin.pages.blogs.tabs_content_detail_post.index', compact('newsTabContentDetails'));
    }

    public function create()
    {
        $news = FinancialSupport::all();
        $tabs = TabDetailPost::all();
        $languages = Language::all();
        return view('admin.pages.blogs.tabs_content_detail_post.create', compact('news', 'tabs','languages'));
    }

    public function store(Request $request)
    {

        $locales = Language::pluck('locale')->toArray();


        $rules = [];
        $messages = [];


        foreach ($locales as $locale) {
            $rules["content_{$locale}"] = 'required|string';
            $messages["content_{$locale}.required"] = __('content') . strtoupper($locale) . __(' is_required.');
            $messages["content_{$locale}.string"] = __('content');
        }
        $rules['financial_support_id'] = 'required|exists:financial_support,id';
        $rules['tab_id'] = 'required|exists:tabs_detail_posts,id';

        $validatedData = $request->validate($rules, $messages);


        $translatedContent = [];
        foreach ($locales as $locale) {
            $translatedContent[$locale] = $request->input("content_{$locale}");
        }

        $contentDetailPost = new NewsTabContentDetailPost();
        $contentDetailPost->setTranslations('content', $translatedContent);
        $contentDetailPost->financial_support_id = $validatedData['financial_support_id'];
        $contentDetailPost->tab_id = $validatedData['tab_id'];
        $contentDetailPost->save();

        return redirect()->route('news_contents.index')->with('success', __('create_success'));
    }


    public function edit($id)
    {
        $newsContent = NewsTabContentDetailPost::findOrFail($id);
        if (!$newsContent) {
            return back()->with('error', __('no_find_data'));
        }
        $news = FinancialSupport::all();
        $tabs = TabDetailPost::all();
        $languages = Language::all();

        return view('admin.pages.blogs.tabs_content_detail_post.edit', compact('newsContent', 'news', 'tabs','languages'));
    }

    public function update(Request $request, string $id)
    {

        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {

            $rules["content_{$locale}"] = 'required|string|max:255';

            $messages["content_{$locale}.required"] = __('content') . strtoupper($locale) . __(' is_required.');
            $messages["content_{$locale}.string"] = __('content_string');
            $messages["content_{$locale}.max"] = __('content_max', ['max' => 255]);
        }


        $validatedData = $request->validate($rules, $messages);


        $newsContent = NewsTabContentDetailPost::findOrFail($id);


        $translatedContent = [];
        foreach ($locales as $locale) {
            $translatedContent[$locale] = $request->input("content_{$locale}");
        }


        $newsContent->setTranslations('content', $translatedContent);


        $newsContent->financial_support_id = $request->input('financial_support_id');
        $newsContent->tab_id = $request->input('tab_id');


        $newsContent->save();


        return redirect()->route('news_contents.index')->with('success', __('update_success'));
    }


    public function destroy($id)
    {
        $category = NewsTabContentDetailPost::find($id);

        if (!$category) {
            return redirect()->route('news_contents.index')->with('error', __('content_not_found'));
        }


        $category->delete();

        return redirect()->route('news_contents.index')->with('success', __('delete_success'));
    }
}
