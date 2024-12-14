<?php

namespace App\Http\Controllers;

use App\Models\CategoryNews;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CategoryNewsController extends Controller
{
    protected $notActionSlugs = [
        'thong-bao',
        'hoat-dong-xuc-tien',
        'hoat-dong-hoi',
        'hoi-cho',
        'tin-tuc',
        'tu-van-khoi-nghiep',
        'khao-sat',
        'ket-noi-giao-thuong',
        'ket-noi-viec-lam',
        'y-kien',
        'about-us-17'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoryNews::where('unit_id',auth()->user()->unit_id)->get();

        $notActionSlugs = $this->notActionSlugs;

        return view('admin.pages.category_blogs.index', compact('categories','notActionSlugs'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.category_blogs.create', compact('languages'));
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

            $existingCategory = CategoryNews::whereJsonContains('name', [$locale => $translatedName[$locale]])->first();
            if ($existingCategory) {
                return back()->withInput()->withErrors([
                    "name_{$locale}" => __('name_category') . ' ' . $translatedName[$locale] . ' ' . __('already_exists')
                ]);
            }
        }
        $slug = Str::slug($translatedName[config('app.locale')]);
        if (CategoryNews::where('slug', $slug)->exists()) {
            return redirect()->back()->with('error', 'Danh mục đã tồn tại, hãy thử với tên danh mục khác.');
        }

        $category = new CategoryNews();
        $category->slug = $slug;
        $category->setTranslations('name', $translatedName);
        $category->unit_id = auth()->user()->unit_id;
        $category->save();

        return redirect()->route('categories-news.index')->with('success', __('create_success'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = CategoryNews::find($id);

        if (!$category) {
            return back()->with('error', 'Danh mục không tồn tại');
        }

        if($category->unit_id != auth()->user()->unit_id)
        {
            return redirect()->back()->with('error','Danh mục không tồn tại');
        }

        $languages = Language::all();
        
        return view('admin.pages.category_blogs.edit', compact('category', 'languages'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $category = CategoryNews::find($id);

        if (!$category) {
            return back()->with('error', 'Danh mục không tồn tại');
        }

        if($category->unit_id != auth()->user()->unit_id)
        {
            return redirect()->back()->with('error','Danh mục không tồn tại');
        }

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

            $existingCategory = CategoryNews::where('id', '!=', $id)
                ->whereJsonContains('name', [$locale => $translatedName[$locale]])
                ->first();

            if ($existingCategory) {
                return back()->withInput()->withErrors([
                    "name_{$locale}" => __('name_category') . ' ' . $translatedName[$locale] . ' ' . __('already_exists')
                ]);
            }
        }
        $slug = Str::slug($translatedName[config('app.locale')]);

        $category->slug = $slug;
        $category->setTranslations('name', $translatedName);
        $category->save();

        return redirect()->route('categories-news.index')->with('success', __('update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = CategoryNews::find($id);

        if (!$category) {
            return redirect()->route('categories-news.index')->with('error', 'Danh mục không tồn tại để xóa');
        }

        if($category->unit_id != auth()->user()->unit_id)
        {
            return redirect()->back()->with('error','Danh mục không tồn tại để xóa');
        }

        // if ($news->published_at && $news->published_at <= now()) {
        //     return redirect()->route('news.index')->with('error', __('You cannot delete a published post.'));
        // }

        $category->delete();

        return redirect()->route('categories-news.index')->with('success', __('category_news_deleted_successfully'));
    }
}
