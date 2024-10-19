<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::all();
        return view('admin.pages.languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.languages.create',compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
            $locales = Language::pluck('locale')->toArray();
            $rules = [
                'name' => 'required',
                'locale' => 'required',
                'flag' => 'required|image',
            ];
            $messages = [
                'name.required' => __('form.name.required'),
                'locale.required' => __('form.locale.required'),
                'flag.required' => __('form.flag.required'),
                'flag.image' => __('form.flag.image'),
            ];
        
            foreach($locales as $locale) {
                $rules["name-{$locale}"] = 'required';
                $messages["name-{$locale}.required"] = __('form.name.locale.required', ['locale' => $locale]);
            }
        
            $request->validate($rules, $messages);
        try {

            try {
                $image = $request->file('flag');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/flags/' . $folderName), $fileName);
                $image_path = 'uploads/images/flags/' . $folderName . '/' . $fileName;
            } catch (Exception $e) {
                if (isset($image_path) && File::exists(public_path($image_path))) {
                    File::delete(public_path($image_path));
                }
                return back()->withInput()->with('error', '[E2] ' . __('language_create_error_flag'));
            }

            $language = new Language();
            $translations = [];
            foreach ($locales as $locale) {
                $translations[$locale] = $request->input("name-{$locale}");
            }
            $translations[$request->locale] = $request->name;
        
            $language->setTranslations('name', $translations);
            $language->locale = $request->locale;
            $language->flag = $image_path;
            
            $language->save();
        } catch (QueryException $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->withInput()->with('error','[E0] ' . __('language_create_error_db'));
        } catch (Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->withInput()->with('error', '[E1] ' . __('create_new_language_error'));
        }
        return redirect()->route('languages.index')->with('success', __('create_new_language_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($language)
    {
        $language = Language::find($language);
        if ($language) {
            $languages = Language::all();
            $translatedNames = json_decode($language->getAttributes()['name'], true);
        
            $allLanguages = $languages->pluck('locale')->toArray();
            
            foreach ($allLanguages as $locale) {
                if (!array_key_exists($locale, $translatedNames)) {
                    $translatedNames[$locale] = ''; 
                }
            }
        
            return view('admin.pages.languages.edit', compact('language', 'translatedNames', 'languages'));
        }
        
        return redirect()->route('languages.index')->with('error', __('language_not_exist_edit'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $language)
    {
        $language = Language::find($language);
        if($language)
        {

            $locales = Language::pluck('locale')->toArray();

            if($request->file('flag')) {
                $rules = [
                    'flag' => 'required|image',
                ];

                $messages = [
                    'flag.required' => __('form.flag.required'),
                    'flag.image' => __('form.flag.image'),
                ];
            } 

            $rules = [
                'locale' => 'required',
            ];

            $messages = [
                'locale.required' => __('form.locale.required'),
            ];
        
            foreach($locales as $locale) {
                $rules["name-{$locale}"] = 'required';
                $messages["name-{$locale}.required"] = __('form.name.locale.required', ['locale' => $locale]);
            }
        
            $request->validate($rules, $messages);

            $image_path = '';
            try {
                $translations = [];
                foreach ($locales as $locale) {
                    $translations[$locale] = $request->input("name-{$locale}");
                }

                $language->setTranslations('name', $translations);
                $language->locale = $request->locale;
                if ($request->hasFile('flag')) {
                    try {
                        $image = $request->file('flag');
                        $folderName = date('Y/m');
                        $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $extension = $image->getClientOriginalExtension();
                        $fileName = $originalFileName . '_' . time() . '.' . $extension;
                        $image->move(public_path('/uploads/images/flags/' . $folderName), $fileName);
                        $image_path = 'uploads/images/flags/' . $folderName . '/' . $fileName;
                       
                        $backup = $language->flag;

                        $language->flag = $image_path;
                    } catch (Exception $e) {
                        if (File::exists(public_path($image_path))) {
                            File::delete(public_path($image_path));
                        }
                        return back()->withInput()->with('error', '[E3] ' . __('language_update_error_flag'));
                    }
                }
                $language->save();

                if (isset($backup) && File::exists(public_path($backup))) {
                    File::delete(public_path($backup));
                }

            } catch (ValidationException $e) {
                if (isset($image_path) && File::exists(public_path($image_path))) {
                    File::delete(public_path($image_path));
                }
                return back()->withInput()->with('error', '[E4] ' . __('language_update_error_db'));
            } catch (Exception $e) {
                if (isset($image_path) && File::exists(public_path($image_path))) {
                    File::delete(public_path($image_path));
                }
                return back()->withInput()->with('error', '[E5] ' . __('update_language_error'));
            }
            return redirect()->route('languages.index')->with('success',__('update_language_success'));
        }

        return redirect()->route('languages.index')->with('error', __('language_not_exist_update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($language)
    {
        $language = Language::find($language);
        if($language) {
            $language->delete();

            if (File::exists(public_path($language->flag))) {
                File::delete(public_path($language->flag));
            }

            return redirect()->route('languages.index')->with('success', __('delete_language_success'));
        }
        return redirect()->route('languages.index')->with('error', __('language_not_exist_delete'));
    }

    public function switchLanguage($locale)
    {

        if(Language::where('locale', $locale)->exists()) {
            Cookie::queue(Cookie::forever('locale', $locale));
            if(auth()->check()) {
                $user = auth()->user();
                $user->language = $locale;
                $user->save();
            }
        }
        return redirect()->back();
    }

    public function editSystem($locale)
    {
        $language = Language::where('locale', $locale)->first();
        if($language) {
            $path = base_path("lang/{$locale}.json");
            if (!file_exists($path)) {
                $path = base_path("lang/" . app()->getLocale() . ".json");
                $jsonContent = file_get_contents($path);
                return view('admin.pages.languages.edit-system', compact('language', 'jsonContent'));
            }
            $jsonContent = file_get_contents($path);

            return view('admin.pages.languages.edit-system', compact('language', 'jsonContent'));
        }
        return redirect()->route('languages.index')->with('error', __('language_not_exist_edit'));
    }

    public function updateSystem(Request $request, $locale)
    {
        $language = Language::where('locale', $locale)->first();
        if ($language) {
            $request->validate([
                'language_system' => 'required',
            ], [
                'language_system.required' => __('form.language_system.required'),
            ]);

            $path = base_path("lang/{$locale}.json");

                file_put_contents($path, $request->language_system);

            return redirect()->route('languages.index')->with('success', __('update_language_system_success', ['name' => $language->name]));
        }

        return redirect()->route('languages.index')->with('error', __('language_not_exist_update'));
            }
}

