<?php

namespace App\Http\Controllers;

use App\Models\Tab;
use App\Models\News;
use App\Models\Forum;
use App\Models\TagNews;
use App\Models\Language;
use App\Models\TabProject;
use Illuminate\Support\Str;
use App\Models\CategoryNews;
use Illuminate\Http\Request;
use App\Models\FinancialSupport;
use App\Http\Controllers\Controller;
use App\Models\BankServicesInterest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;


class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index(Request $request)
    {
        $unit_id = Auth::user()->unit_id;

        $search = $request->input('search');
        $searchCategory = $request->input('search-category');
        $blogs = News::query();

        // Lọc theo tiêu đề nếu có từ khóa tìm kiếm
        if ($search) {
            $blogs = $blogs->where('title', 'like', '%' . $search . '%');
        }

        // Lọc theo category nếu có từ khóa tìm kiếm category
        if ($searchCategory) {
            $blogs = $blogs->whereHas('categories', function ($query) use ($searchCategory) {
                $query->where('name', 'like', '%' . $searchCategory . '%')
                    ->orWhere('slug', $searchCategory);
            });
        }

        // Lọc theo unit_id của người dùng hiện tại
        $blogs = $blogs->whereHas('categories', function ($query) use ($unit_id) {
            $query->where('unit_id', $unit_id);
        });

        // Lọc các categories không có slug là 'khao-sat' và 'hoi-cho'
        $categories = CategoryNews::where('unit_id', $unit_id)
            ->where('slug', '!=', 'khao-sat')
            ->where('slug', '!=', 'hoi-cho')
            ->get();

        // Lọc các blogs không có categories với slug là 'khao-sat' và 'hoi-cho'
        $blogs = $blogs->orderBy('published_at', 'desc')
            ->whereHas('categories', function ($query) {
                $query->whereNotIn('slug', ['khao-sat', 'hoi-cho']);
            })
            ->paginate(15);

        return view('admin.pages.blogs.index', compact('blogs', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        $unit_id = Auth::user()->unit_id;
        $categories = CategoryNews::where('unit_id', $unit_id)->where('slug', '!=', 'khao-sat')->where('slug', '!=', 'hoi-cho')->get();
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
        $unit_id = Auth::user()->unit_id;
        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["content_{$locale}"] = 'required|string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.required"] = __('content_required');
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
                return redirect()->back()->with('error', __('slug_exists'))->withInput();
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
            }else{
                return back()->withInput()->with('error', 'Ảnh không được để trống.');
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
                    $category_id = $request->input('categories');

                    // Kiểm tra xem category có thuộc về unit_id của người dùng hiện tại không
                    $category = CategoryNews::where('id', $category_id)
                        ->where('unit_id', Auth::user()->unit_id)
                        ->where('slug', '!=', 'khao-sat')
                        ->where('slug', '!=', 'hoi-cho')
                        ->first();

                    if ($category) {
                        $tab_content->categories()->attach($category_id);
                    } else {
                        return redirect()->back()->with('error', 'Danh mục không tồn tại.')->withInput();
                    }
                } else {
                    return redirect()->back()->with('error', 'Danh mục không được để trống.')->withInput();
                }

                if ($request->filled('tags')) {
                    $tab_content->tags()->attach($request->input('tags'));
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', __('create_post_error'))->withInput();
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
        $news = News::find($id);
        if (!$news || !$news->categories()->where('unit_id', Auth::user()->unit_id)->where('slug', '!=', 'khao-sat')->where('slug', '!=', 'hoi-cho')->exists()) {
            return back()->with('error', __('no_find_data'));
        }
        $unit_id = Auth::user()->unit_id;
        $categories = CategoryNews::where('unit_id', $unit_id)->where('slug', '!=', 'khao-sat')->where('slug', '!=', 'hoi-cho')->get();
        $tags = TagNews::all();
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

            if(!$news || !$news->categories()->where('unit_id', Auth::user()->unit_id)->where('slug', '!=', 'khao-sat')->where('slug', '!=', 'hoi-cho')->exists()){
                return back()->with('error', __('no_find_data'))->withInput();
            }

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
                    return back()->withInput()->with('error', __('upload_image_error'))->withInput();
                }
            }

            $news->setTranslations('title', $translateTitle);
            $news->setTranslations('content', $translateContent);
            $news->published_at = $request->input('published_at');
            try {
                if ($request->filled('category_id')) {
                    $category_id = $request->input('category_id');

                    // Kiểm tra xem category có thuộc về unit_id của người dùng hiện tại không
                    $category = CategoryNews::where('id', $category_id)
                        ->where('unit_id', Auth::user()->unit_id)
                        ->where('slug', '!=', 'khao-sat')
                        ->where('slug', '!=', 'hoi-cho')
                        ->first();

                    if ($category) {
                        $news->categories()->sync($category_id);
                    } else {
                        return redirect()->back()->with('error', 'Danh mục không tồn tại.')->withInput();
                    }
                } else {
                    return redirect()->back()->with('error', 'Danh mục không được để trống.')->withInput();
                }

                if ($request->filled('tag_id')) {
                    $news->tags()->sync($request->input('tag_id'));
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', __('update_error'))->withInput();
            }

            $news->save();

            return redirect()->route('news.index')->with('success', __('update_success'));
        } catch (\Exception $e) {
            if (isset($news->image) && File::exists(public_path($news->image))) {
                File::delete(public_path($news->image));
            }
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

        // Kiểm tra xem bài viết có nằm trong category thuộc unit hiện tại không
        $unit_id = Auth::user()->unit_id;
        $belongsToUnit = $news->categories()
            ->where('unit_id', $unit_id)
            ->where('slug', '!=', 'khao-sat')
            ->where('slug', '!=', 'hoi-cho')
            ->exists();

        if (!$belongsToUnit) {
            return redirect()->route('news.index')->with('error', __('news_not_found'));
        }

        // Xóa bài viết
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
                // Lấy danh sách slug của categories
                $categorySlugs = CategoryNews::whereHas('unit', function ($query) {
                    $query->where('unit_code', 'QGV');
                })
                    ->whereNotIn('slug', ['thong-bao', 'khao-sat', 'hoat-dong-hoi'])
                    ->pluck('slug')
                    ->toArray();

                if ($subCategory !== 'all') {
                    $query->whereHas('categories', fn($q) => $q->where('slug', $subCategory));
                } else {
                    $query->whereHas('categories', fn($q) => $q->whereIn('slug', $categorySlugs));
                }
            } else {
                $categorySlugs = [$categorySlug];
            }
            $query->whereHas('categories', fn($q) => $q->whereIn('slug', $categorySlugs));
            // Lấy toàn bộ thông tin của categories
            $categories = CategoryNews::whereIn('slug', $categorySlugs)->get();
            $category = CategoryNews::whereIn('slug', $categorySlugs)->get();
        } else {
            $category = null;
            $categories = collect(); // Trả về một collection rỗng nếu không có category
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
        $tags = TagNews::all();

        $recentPosts = News::orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.blogs.blogs', compact('blogs', 'categories', 'tags', 'recentPosts', 'noResults', 'category', 'subCategory', 'categorySlug'));
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
