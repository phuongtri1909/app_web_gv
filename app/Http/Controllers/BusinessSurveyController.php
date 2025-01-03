<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Business;
use App\Models\Language;
use Illuminate\Support\Str;
use App\Models\CategoryNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use App\Models\NewsDigitalTransformation;
use Illuminate\Validation\ValidationException ;

class BusinessSurveyController extends Controller
{
    public function businessSurvey(Request $request)
    {
        $category = CategoryNews::where('slug', 'khao-sat')->first();

        $businessSurvey = News::whereHas('categories', function ($query) use ($category) {
            $query->where('id', $category->id);
        })
        ->where(function ($query) {
            $query->orWhere('published_at', '<=', now());
        })
        ->where(function ($query) {
            $query->orWhere('expired_at', '>=', now());
        })
        ->paginate(15);
        // dd($businessSurvey);
        $noResults = $businessSurvey->isEmpty();

        foreach ($businessSurvey as $blog) {
            $blog->shortContent = Str::limit(strip_tags($blog->content), 1000);
        }

        return view('pages.client.business-survey.business-survey', compact('businessSurvey', 'noResults', 'category'));
    }


    public function index()
    {
        $category = CategoryNews::where('slug', 'khao-sat')->first();
        $blogs = [];
        if ($category) {
            $blogs = News::with('categories')
                ->whereHas('categories', function ($query) use ($category) {
                    $query->where('id', $category->id);
                })
                ->latest('published_at')
                ->paginate(15);
        }

        $newsDigitalTransformations = NewsDigitalTransformation::pluck('news_id')->toArray();

        return view('admin.pages.client.business-survey.index', compact('blogs', 'newsDigitalTransformations'));
    }



    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.client.business-survey.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        $rules = [
            'published_at' => 'required|date|before_or_equal:expired_at',
            'expired_at' => 'required|date|after:published_at',
        ];
        $messages = [
            'published_at.required' => __('Ngày bắt đầu là bắt buộc.'),
            'published_at.date' => __('Ngày bắt đầu phải là ngày hợp lệ.'),
            'published_at.before_or_equal' => __('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày hết hạn.'),

            'expired_at.required' => __('Ngày hết hạn là bắt buộc.'),
            'expired_at.date' => __('Ngày hết hạn phải là ngày hợp lệ.'),
            'expired_at.after' => __('Ngày hết hạn phải lớn hơn ngày bắt đầu.'),
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

            $news = new News();
            $news->user_id = Auth::id();
            $news->setTranslations('title', $translateTitle);
            $news->setTranslations('content', $tranSlateContent);
            $news->image = $image_path;
            $news->slug = $slug;
            $news->published_at = $request->input('published_at');
            $news->expired_at = $request->input('expired_at');
            $news->save();

            $category = CategoryNews::where('slug', 'khao-sat')->first();
            $news->categories()->attach($category->id);
                
            
            return redirect()->route('survey.index')->with('success', __('create_post_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('create_post_error')])->withInput();
        }
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
        if (!$news || !$news->categories()->where('unit_id', Auth::user()->unit_id)->where('slug', 'khao-sat')->exists()) {
            return back()->with('error', __('no_find_data'));
        }
        $languages = Language::all();

        return view('admin.pages.client.business-survey.edit', compact('news', 'languages'));
    }


    public function update(Request $request, $id)
    {
        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];
        $rules = [
            'published_at' => 'required|date|before_or_equal:expired_at',
            'expired_at' => 'required|date|after:published_at',
        ];
        $messages = [
            'published_at.required' => __('Ngày bắt đầu là bắt buộc.'),
            'published_at.date' => __('Ngày bắt đầu phải là ngày hợp lệ.'),
            'published_at.before_or_equal' => __('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày hết hạn.'),

            'expired_at.required' => __('Ngày hết hạn là bắt buộc.'),
            'expired_at.date' => __('Ngày hết hạn phải là ngày hợp lệ.'),
            'expired_at.after' => __('Ngày hết hạn phải lớn hơn ngày bắt đầu.'),
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
            $news = News::findOrFail($id);

            if(!$news->categories()->where('unit_id', Auth::user()->unit_id)->where('slug', 'khao-sat')->exists()) {
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
                    return back()->withInput()->with('error', __('upload_image_error'));
                }
            }

            $news->setTranslations('title', $translateTitle);
            $news->setTranslations('content', $translateContent);
            $news->published_at = $request->input('published_at');
            $news->expired_at = $request->input('expired_at');
            
            $category = CategoryNews::where('slug', 'khao-sat')->first();
            $news->categories()->sync($category->id);
               
            $news->save();

            return redirect()->route('survey.index')->with('success', __('update_success'));
        } catch (\Exception $e) {
            if (isset($news->image) && File::exists(public_path($news->image))) {
                File::delete(public_path($news->image));
            }
            return back()->with('error' , __('update_error') . ' ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $news = News::find($id);

        if (!$news || !$news->categories()->where('unit_id', Auth::user()->unit_id)->where('slug', 'khao-sat')->exists()) {
            return redirect()->route('survey.index')->with('error', 'Khảo sát không tồn tại');
        }

        $newsDigitalTransformation = NewsDigitalTransformation::where('news_id', $news->id)->first();
        if ($newsDigitalTransformation) {
            $newsDigitalTransformation->digitalTransformation->delete();
        }

        $news->delete();

        return redirect()->route('survey.index')->with('success', 'Xóa khảo sát thành công');
    }
}
