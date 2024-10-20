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
        $newsTabContentDetails = NewsTabContentDetailPost::with(['financialSupport', 'tab'])->get();

        // if ($newsTabContentDetails->isEmpty()) {
        //     return redirect()->back()->with('error', 'Không tìm thấy');
        // }

        foreach ($newsTabContentDetails as $detail) {
            if (!$detail->financialSupport || !$detail->tab) {
                $missingRelations = [];

                if (!$detail->financialSupport) {
                    $missingRelations[] = 'Financial Support';
                }

                if (!$detail->tab) {
                    $missingRelations[] = 'Tab';
                }

                $errorMessage = 'Một số chi tiết nội dung bị thiếu các mối quan hệ bắt buộc: ' . implode(', ', $missingRelations);

                return redirect()->back()->with('error', $errorMessage);
            }

        }

        return view('admin.pages.blogs.tabs_content_detail_post.index', compact('newsTabContentDetails'));
    }


    public function create()
    {
        $news = FinancialSupport::all();
        $tabs = TabDetailPost::all();
        return view('admin.pages.blogs.tabs_content_detail_post.create', compact('news', 'tabs'));
    }


    public function store(Request $request)
    {
        $rules = [
            'content' => 'required|string', 
            'financial_support_id' => 'required|exists:financial_support,id',
            'tab_id' => 'required|exists:tabs_detail_posts,id',
        ];

        $messages = [
            'content.required' => __('content') . __(' is_required.'),
            'content.string' => __('content_string'),
        ];

        $validatedData = $request->validate($rules, $messages);

        $contentDetailPost = new NewsTabContentDetailPost();
        $contentDetailPost->content = $validatedData['content'];
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

        return view('admin.pages.blogs.tabs_content_detail_post.edit', compact('newsContent', 'news', 'tabs'));
    }


    public function update(Request $request, string $id)
    {
        $rules = [
            'content' => 'required|string|max:255',
            'financial_support_id' => 'required|exists:financial_support,id',
            'tab_id' => 'required|exists:tabs_detail_posts,id',
        ];

        $messages = [
            'content.required' => __('content') . __(' is_required.'),
            'content.string' => __('content_string'),
            'content.max' => __('content_max', ['max' => 255]),
        ];

        $validatedData = $request->validate($rules, $messages);

        $newsContent = NewsTabContentDetailPost::findOrFail($id);
        $newsContent->content = $validatedData['content'];
        $newsContent->financial_support_id = $validatedData['financial_support_id'];
        $newsContent->tab_id = $validatedData['tab_id'];
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
