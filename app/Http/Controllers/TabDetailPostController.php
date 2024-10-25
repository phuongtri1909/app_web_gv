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
        return view('admin.pages.blogs.tabs_detail_post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:tabs_detail_posts,name',
        ];

        $messages = [
            'name.required' => __('name_is_required'),
            'name.string' => __('name_string'),
            'name.max' => __('name_max', ['max' => 255]),
            'name.unique' => __('Tên đã tồn tại !!'),
        ];
        $validatedData = $request->validate($rules, $messages);
        $existingCategory = TabDetailPost::where('name', $validatedData['name'])->first();
        dd($existingCategory);
        if ($existingCategory) {
            return back()->withInput()->withErrors([
                'name' => __('Tên đã tồn tại !!')
            ]);
        }
        dd($validatedData);
        $category = new TabDetailPost();
        $category->name = $validatedData['name'];
        $category->save();

        return redirect()->route('tabs_posts.index')->with('success', __('create_success'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = TabDetailPost::findOrFail($id);
        if (!$category) {
            return back()->with('error', __('no_find_data'));
        }

        return view('admin.pages.blogs.tabs_detail_post.edit', compact('category'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];

        $messages = [
            'name.required' => __('name_is_required'),
            'name.string' => __('name_string'),
            'name.max' => __('name_max', ['max' => 255]),
        ];

        $validatedData = $request->validate($rules, $messages);
        $detailPost = TabDetailPost::findOrFail($id);
        $existingCategory = TabDetailPost::where('name', $validatedData['name'])->first();
        if ($existingCategory &&   $existingCategory != $detailPost ) {
            return back()->withInput()->withErrors([
                'name' => __('Tên đã tồn tại!!')
            ]);
        }
        $category = TabDetailPost::findOrFail($id);
        $category->name = $request->input('name');
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
