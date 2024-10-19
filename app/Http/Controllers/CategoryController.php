<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tab;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\CategoryProgram;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoryProgram::orderBy('created_at', 'desc')->get();
        $tab = Tab::where('slug', 'programs-content')->first();
        return view('admin.pages.categories.index', compact('categories', 'tab'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $keyPages = [
            'page_home' => 'Page Home',
            'page_program' => 'Page Program',
            'key_cb2' => 'Key Component 2'
        ];
        $languages = Language::all();
        return view('admin.pages.categories.create', compact('keyPages', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    
    $locales = Language::pluck('locale')->toArray();

    $rules = [
        'key_page' => 'required|in:page_home,page_program,key_cb2',
    ];
    
    foreach ($locales as $locale) {
        $rules["name_category-{$locale}"] = 'string|max:255';
        $rules["desc_category-{$locale}"] = 'string';
    }

    $messages = [
        'key_page.required' => __('form.key_page.required'),
        'key_page.in' => __('form.key_page.invalid'),
    ];

    $validatedData = $request->validate($rules, $messages);

    
    if (CategoryProgram::where('key_page', $request->input('key_page'))->exists()) {
        return back()->withInput()->with('error', __('key_page_already_exists'));
    }

    
    try {
        $category = new CategoryProgram();
        $translationsNameCate = [];
        $translationsDesCate= [];

        foreach ($locales as $locale) {
            $translationsNameCate[$locale] = $request->input("name_category-{$locale}");
            $translationsDesCate[$locale] = $request->input("desc_category-{$locale}");
        }

        $translationsNameCate[$request->locale] = $request->input('name_category');
        $translationsDesCate[$request->locale] = $request->input('desc_category');

        $category->setTranslations('name_category', $translationsNameCate);
        $category->setTranslations('desc_category', $translationsDesCate);
        $category->key_page = $request->input('key_page');
        $category->save();
        return redirect()->route('categories.index')->with('success', __('create_category_success'));

    } catch (QueryException $e) {
        
        return back()->withInput()->with('error', '[E20] ' . __('category_create_error_db') . ': ' . $e->getMessage());
        
    } catch (Exception $e) {
        
        return back()->withInput()->with('error', '[E21] ' . __('create_new_category_error') . ': ' . $e->getMessage());
    }
}


    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = CategoryProgram::find($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', '[E18] ' . __('category_not_found'));
        }

        $languages = Language::all();
    
        return view('admin.pages.categories.edit', compact('category', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = CategoryProgram::find($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', '[E19] ' . __('category_not_found'));
        }

        $languages = Language::pluck('locale')->toArray();
        foreach ($languages as $locale) {
            $rules["name_category_{$locale}"] = 'string|max:255';
            $rules["desc_category_{$locale}"] = 'string';

            $messages["name_category_{$locale}.string"] = __('form.name_category.string');
            $messages["name_category_{$locale}.max"] = __('form.name_category.max');
        }
    
        $validatedData = $request->validate($rules, $messages);

        try {
            $translationsNameCate = [];
            $translationsDesCate = [];

            foreach ($languages as $locale) {
                $translationsNameCate[$locale] = $request->input("name_category_{$locale}");
                $translationsDesCate[$locale] = $request->input("desc_category_{$locale}");
            }

            $category->setTranslations('name_category', $translationsNameCate);
            $category->setTranslations('desc_category', $translationsDesCate);
            $category->save();
            return redirect()->route('categories.index')->with('success', __('update_category_success'));

        } catch (QueryException $e) {
            return back()->withInput()->with('error', '[E20] ' . __('category_update_error_db') . ': ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->withInput()->with('error', '[E21] ' . __('update_category_error') . ': ' . $e->getMessage());
        }
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = CategoryProgram::find($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', __('category_not_found'));
        }

        try {
            $category->delete();
            return redirect()->route('categories.index')->with('success', __('delete_category_success'));

        } catch (QueryException $e) {
            return back()->with('error', '[E22] ' . __('category_delete_error_db'));
        } catch (Exception $e) {
            return back()->with('error', '[E23] ' . __('delete_category_error'));
        }
    }

}