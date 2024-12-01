<?php

namespace App\Http\Controllers;

use App\Models\CategoryNews;
use App\Models\FinancialSupport;
use App\Models\Forum;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BankServicesInterest;
use App\Models\Language;
use App\Models\Tab;
use App\Models\TabProject;
use App\Models\TagNews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchCategory = $request->input('search-category');
        $blogs = News::query();
        if ($search) {
            $blogs = $blogs->where('title', 'like', '%' . $search . '%');
        }
        if ($searchCategory) {
            $blogs = $blogs->whereHas('categories', function ($query) use ($searchCategory) {
                $query->where('name', 'like', '%'.$searchCategory.'%')->orWhere('slug', $searchCategory)
                        ->orWhere('slug', $searchCategory);
            });
        }
        $categories = CategoryNews::where('slug', '!=', 'khao-sat')->where('slug', '!=', 'hoi-cho')->get();
        $blogs = $blogs->orderBy('published_at', 'desc')->whereHas('categories', function ($query) { $query->whereNotIn('slug', ['khao-sat', 'hoi-cho']);})->paginate(15);
        return view('admin.pages.blogs.index', compact('blogs', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        $categories = CategoryNews::where('slug', '!=', 'khao-sat')->get();
        $tags = TagNews::all();
        $languages = Language::all();
        return view('admin.pages.blogs.create', compact('categories', 'tags', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
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
        $validatedData = $request->validate($rules, $messages);

        try {
            $translateTitle = [];
            $tranSlateContent = [];
            $image_path = null;

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $tranSlateContent[$locale] = $request->get("content_{$locale}");
            }

            $slug = Str::slug($translateTitle[config('app.locale')]);

            if (News::where('slug', $slug)->exists()) {
                return redirect()->back()->with('error', __('slug_exists'));
            }

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/news/' . $folderName), $fileName);
                    $image_path = 'uploads/images/news/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }
            }

            $tab_content = new News();
            $tab_content->user_id = Auth::id();
            $tab_content->setTranslations('title', $translateTitle);
            $tab_content->setTranslations('content', $tranSlateContent);
            $tab_content->image = $image_path;
            $tab_content->slug = $slug;
            $tab_content->published_at = $request->input('published_at');
            $tab_content->save();

            try {
                if ($request->filled('categories')) {
                    $tab_content->categories()->attach($request->input('categories'));
                }

                if ($request->filled('tags')) {
                    $tab_content->tags()->attach($request->input('tags'));
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', __('create_post_error'));
            }

            return redirect()->route('news.index')->with('success', __('create_post_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('create_post_error')])->withInput();
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        $blogPost = News::find($id);
        return view('admin.pages.blogs.show', compact('blogPost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     */
    public function edit($id)
    {
        $categories = CategoryNews::where('slug', '!=', 'khao-sat')->where('slug', '!=', 'hoi-cho')->get();
        $tags = TagNews::all();
        $news = News::find($id);
        if (!$news) {
            return back()->with('error', __('no_find_data'));
        }
        $languages = Language::all();

        return view('admin.pages.blogs.edit', compact('news', 'languages', 'categories', 'tags'));
    }


    public function update(Request $request, $id)
    {
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

        $validatedData = $request->validate($rules, $messages);

        try {
            $news = News::findOrFail($id);

            $translateTitle = [];
            $translateContent = [];
            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateContent[$locale] = $request->get("content_{$locale}");
            }

            if ($request->hasFile('image')) {
                try {
                    if ($news->image && File::exists(public_path($news->image))) {
                        File::delete(public_path($news->image));
                    }

                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/news/' . $folderName), $fileName);
                    $news->image = 'uploads/images/news/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($news->image) && File::exists(public_path($news->image))) {
                        File::delete(public_path($news->image));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }
            }

            $news->setTranslations('title', $translateTitle);
            $news->setTranslations('content', $translateContent);
            $news->published_at = $request->input('published_at');
            // try {
            //     if ($request->filled('category_id')) {
            //         $news->categories()->sync($request->input('category_id'));
            //     }

            //     if ($request->filled('tag_id')) {
            //         $news->tags()->sync($request->input('tag_id'));
            //     }
            // } catch (\Exception $e) {
            //     return redirect()->back()->with('error', __('update_error'));
            // }
            // dd($request->input('categories'), $request->input('tags'));
            // dd($news);

            $news->save();

            return redirect()->route('news.index')->with('success', __('update_success'));
        } catch (\Exception $e) {
            if (isset($news->image) && File::exists(public_path($news->image))) {
                File::delete(public_path($news->image));
            }
            // return $e->getMessage();
            return back()->with(['error' => __('update_error')])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    public function destroy($id)
    {
        $news = News::find($id);

        if (!$news) {
            return redirect()->route('news.index')->with('error', __('news_not_found'));
        }

        // if ($news->published_at && $news->published_at <= now()) {
        //     return redirect()->route('news.index')->with('error', __('You cannot delete a published post.'));
        // }

        $news->delete();

        return redirect()->route('news.index')->with('success', __('news_deleted_successfully'));
    }

    public function blogIndex(Request $request)
    {

        $query = News::query();
        if ($request->has('category') && $request->input('category') !== 'all') {
            $categorySlug = $request->input('category');
            $subCategory = $request->input('subCategory', 'all');
            if ($categorySlug === 'hoat-dong-xuc-tien') {
                $categories = ['hoat-dong-xuc-tien', 'tin-tuc', 'hoi-cho'];
                if ($subCategory !== 'all') {
                    $query->whereHas('categories', fn($q) => $q->where('slug', $subCategory));
                } else {
                    $query->whereHas('categories', fn($q) => $q->whereIn('slug', $categories));
                }
            } else {
                $categories = [$categorySlug];
            }
            $query->whereHas('categories', fn($q) => $q->whereIn('slug', $categories));
            $category = CategoryNews::whereIn('slug', $categories)->get();
        } else {
            $category = null;
        }


        if ($request->has('tag')) {
            $tagId = $request->input('tag');
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('id', $tagId);
            });
        }

        $blogs = $query->orderBy('published_at', 'desc')->paginate(10, ['*'], 'page');
        $noResults = $blogs->isEmpty();
        foreach ($blogs as $blog) {
            $blog->shortContent = Str::limit(strip_tags($blog->content), 1000);
        }
        $categories = CategoryNews::all();
        $tags = TagNews::all();

        $recentPosts = News::orderBy('published_at', 'desc')
            ->take(5)
            ->get();


        return view('pages.blogs.blogs', compact( 'blogs', 'categories', 'tags', 'recentPosts', 'noResults', 'category', 'subCategory','categorySlug'));

    }


    public function showBlogIndex($slug)
    {
        $blog = News::where('slug', $slug)->firstOrFail();

        $blog->formatted_published_at = $this->formatDate($blog->published_at);
        $isHoiCho = $blog->categories->contains('slug', 'hoi-cho') ? 'hoi-cho' : null;
        $isHoatDongXucTien = $blog->categories->contains('slug', 'hoat-dong-xuc-tien') ? 'hoat-dong-xuc-tien' : null;
        $relatedPosts = News::whereHas('categories', function ($query) use ($blog) {
            $query->whereIn('id', $blog->categories->pluck('id'));
        })->where('id', '!=', $blog->id)
            ->limit(5)
            ->get();

        return view('pages.blogs.blog-detail', [
            'blog' => $blog,
            'relatedPosts' => $relatedPosts,
            'isHoiCho' => $isHoiCho,
            'news_id' => $blog->id,
            'isHoatDongXucTien' => $isHoatDongXucTien,
        ]);
    }


    public function showPostIndex($slug)
    {

        $blog = FinancialSupport::where('slug', $slug)
            ->with('tabContentDetails.tab')
            ->first();
        if (!$blog) {
            $blog = BankServicesInterest::where('slug', $slug)
                ->with('tabContentDetails.tab')
                ->firstOrFail();
        }
        return view('pages.client.gv.post-detail', compact('blog'));
    }
    // public function showBlogIndexMini($slug)
    // {
    //     $blog = TabProject::where('slug', $slug)->firstOrFail();

    //     $blog->formatted_published_at = $this->formatDate($blog->published_at);


    //     return view('pages.detail-dev-blog', compact('blog',));
    // }



    /**
     *
     *
     * @param string $date
     * @return string
     */
    private function formatDate($date)
    {
        $locale = app()->getLocale();
        \Carbon\Carbon::setLocale($locale);

        $date = \Carbon\Carbon::parse($date);

        return $date->translatedFormat('d F Y');
    }
}
