<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Slider;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('created_at', 'desc')->get();
        return view('admin.pages.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.sliders.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $locales = Language::pluck('locale')->toArray();
        $rules = [
            'image_slider' => 'required|image',
            'learn_more_url' => 'required|url',
            'active' => 'required|in:yes,no',
            'key_page' => 'required|string',
        ];

        $messages = [
            'learn_more_url.required' => __('form.learn_more_url.required'),
            'learn_more_url.url' => __('form.learn_more_url.url'),
            'active.required' => __('form.active.required'),
            'active.in' => __('form.active.in'),
            'image_slider.required' => __('form.image_slider.required'),
            'image_slider.file' => __('form.image_slider.file'),
            'image_slider.mimes' => __('form.image_slider.mimes'),
            'image_slider.max' => __('form.image_slider.max'),
            'key_page.required' => __('form.key_page.required'),
        ];

        foreach ($locales as $locale) {
            $rules["slider_title-{$locale}"] = 'required|string|max:255';
            $rules["title-{$locale}"] = 'required|string|max:255';
            $rules["subtitle-{$locale}"] = 'nullable|string|max:255';
            $rules["description-{$locale}"] = 'required|string';

            $messages["slider_title-{$locale}.required"] = __('form.slider_title.locale.required', ['locale' => $locale]);
            $messages["title-{$locale}.required"] = __('form.title.locale.required', ['locale' => $locale]);
            $messages["subtitle-{$locale}.required"] = __('form.subtitle.locale.required', ['locale' => $locale]);
            $messages["description-{$locale}.required"] = __('form.description.locale.required', ['locale' => $locale]);
        }
        $request->validate($rules, $messages);
        try {
            try {
                if ($request->hasFile('image_slider')) {
                    $sliderFile = $request->file('image_slider');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($sliderFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $sliderFile->getClientOriginalExtension();
                    $sliderFileName = $originalFileName . '_' . time() . '.' . $extension;
                    $uploadPath = public_path('uploads/images/sliders/' . $folderName);

                    // Kiểm tra và tạo thư mục nếu chưa tồn tại
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    // Giảm dung lượng ảnh và lưu ảnh
                    $image = Image::make($sliderFile->getRealPath());
                    $image->save($uploadPath . '/' . $sliderFileName, 75);

                    $sliderFilePath = 'uploads/images/sliders/' . $folderName . '/' . $sliderFileName;
                }
            } catch (Exception $e) {
                if (isset($sliderFilePath) && File::exists(public_path($sliderFilePath))) {
                    File::delete(public_path($sliderFilePath));
                }
                return back()->withInput()->with('error', '[E15] ' . __('form.image_url.required'));
            }

            $slider = new Slider();
            $translationsSliderTitle = [];
            $translationsTitle = [];
            $translationsSubtitle = [];
            $translationsDescription = [];

            foreach ($locales as $locale) {
                $translationsSliderTitle[$locale] = $request->input("slider_title-{$locale}");
                $translationsTitle[$locale] = $request->input("title-{$locale}");
                $translationsSubtitle[$locale] = $request->input("subtitle-{$locale}");
                $translationsDescription[$locale] = $request->input("description-{$locale}");
            }

            $translationsSliderTitle[$request->locale] = $request->input('slider_title');
            $translationsTitle[$request->locale] = $request->input('title');
            $translationsSubtitle[$request->locale] = $request->input('subtitle');
            $translationsDescription[$request->locale] = $request->input('description');

            $slider->setTranslations('slider_title', $translationsSliderTitle);
            $slider->setTranslations('title', $translationsTitle);
            $slider->setTranslations('subtitle', $translationsSubtitle);
            $slider->setTranslations('description', $translationsDescription);

            $slider->image_slider = $sliderFilePath;
            $slider->learn_more_url = $request->input('learn_more_url');
            $slider->active = $request->input('active');
            $slider->key_page = $request->input('key_page');
            $slider->save();

        } catch (QueryException $e) {
            if (isset($sliderFilePath) && File::exists(public_path($sliderFilePath))) {
                File::delete(public_path($sliderFilePath));
            }
            return back()->withInput()->with('error', '[E16] ' . __('slider_create_error_db'));
        }catch (Exception $e) {
            if (isset($sliderFilePath) && File::exists(public_path($sliderFilePath))) {
                File::delete(public_path($sliderFilePath));
            }
            return back()->withInput()->with('error', '[E17] ' . __('create_new_slider_error'));

        }
        return redirect()->route('sliders.index')->with('success', __('create_slider_success'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $slider = Slider::find($id);

        if ($slider) {
            $languages = Language::all();
            $translatedTitles = json_decode($slider->getAttributes()['slider_title'], true);
            $translatedTitlesAlt = json_decode($slider->getAttributes()['title'], true);
            $translatedSubtitles = json_decode($slider->getAttributes()['subtitle'], true);
            $translatedDescriptions = json_decode($slider->getAttributes()['description'], true);

            $allLocales = $languages->pluck('locale')->toArray();

            foreach ($allLocales as $locale) {
                if (!array_key_exists($locale, $translatedTitles)) {
                    $translatedTitles[$locale] = '';
                }
                if (!array_key_exists($locale, $translatedDescriptions)) {
                    $translatedDescriptions[$locale] = '';
                }
                if (!array_key_exists($locale, $translatedSubtitles)) {
                    $translatedSubtitles[$locale] = '';
                }
                if (!array_key_exists($locale, $translatedTitlesAlt)) {
                    $translatedTitlesAlt[$locale] = '';
                }
            }

            return view('admin.pages.sliders.edit', compact(
                'slider',
                'translatedTitles',
                'translatedDescriptions',
                'translatedSubtitles',
                'translatedTitlesAlt',
                'languages'
            ));
        }

        return redirect()->route('sliders.index')->with('error', '[E18] ' . __('slider_not_found'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $locales = Language::pluck('locale')->toArray();
        $slider = Slider::find($id);

        if (!$slider) {
            return redirect()->route('sliders.index')->with('error', '[E19] ' . __('slider_not_found'));
        }

        $rules = [
            'image_slider' => 'nullable|image',
            'learn_more_url' => 'required|url',
            'active' => 'required|in:yes,no',
            'key_page' => 'required|string',
        ];

        $messages = [
            'learn_more_url.required' => __('form.learn_more_url.required'),
            'learn_more_url.url' => __('form.learn_more_url.url'),
            'active.required' => __('form.active.required'),
            'active.in' => __('form.active.in'),
            'image_slider.image' => __('form.image_slider.image'),
            'key_page.required' => __('form.key_page.required'),
        ];
        foreach ($locales as $locale) {
            $rules["slider_title-{$locale}"] = 'required|string|max:255';
            $rules["title-{$locale}"] = 'required|string|max:255';
            $rules["subtitle-{$locale}"] = 'nullable|string|max:255';
            $rules["description-{$locale}"] = 'required|string';

            $messages["slider_title-{$locale}.required"] = __('form.slider_title.locale.required', ['locale' => $locale]);
            $messages["title-{$locale}.required"] = __('form.title.locale.required', ['locale' => $locale]);
            $messages["subtitle-{$locale}.required"] = __('form.subtitle.locale.required', ['locale' => $locale]);
            $messages["description-{$locale}.required"] = __('form.description.locale.required', ['locale' => $locale]);
        }

        $validatedData = $request->validate($rules, $messages);

        try {
            $sliderFilePath = $slider->image_slider;
            if ($request->hasFile('image_slider')) {
                $sliderFile = $request->file('image_slider');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($sliderFile->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $sliderFile->getClientOriginalExtension();
                $sliderFileName = $originalFileName . '_' . time() . '.' . $extension;
                $uploadPath = public_path('uploads/images/sliders/' . $folderName);

                // Kiểm tra và tạo thư mục nếu chưa tồn tại
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                // Giảm dung lượng ảnh và lưu ảnh
                $image = Image::make($sliderFile->getRealPath());
                $image->save($uploadPath . '/' . $sliderFileName, 75);

                $sliderFilePath = 'uploads/images/sliders/' . $folderName . '/' . $sliderFileName;

                // Xóa ảnh cũ nếu có
                if ($slider->image_slider && File::exists(public_path($slider->image_slider))) {
                    File::delete(public_path($slider->image_slider));
                }

                $slider->image_slider = $sliderFilePath;
            }
            $translations = [];
            foreach ($locales as $locale) {
                $translations['slider_title'][$locale] = $request->input("slider_title-{$locale}");
                $translations['title'][$locale] = $request->input("title-{$locale}");
                $translations['subtitle'][$locale] = $request->input("subtitle-{$locale}");
                $translations['description'][$locale] = $request->input("description-{$locale}");
            }
            $slider->setTranslations('slider_title', $translations['slider_title']);
            $slider->setTranslations('title', $translations['title']);
            $slider->setTranslations('subtitle', $translations['subtitle']);
            $slider->setTranslations('description', $translations['description']);

            $slider->learn_more_url = $validatedData['learn_more_url'];
            $slider->active = $validatedData['active'];
            $slider->key_page = $validatedData['key_page'];
            $slider->save();
        } catch (QueryException $e) {
            return back()->withInput()->with('error', '[E16] ' . __('slider_update_error_db'));
        } catch (Exception $e) {
            return back()->withInput()->with('error', '[E17] ' . __('update_new_slider_error'));
        }

        return redirect()->route('sliders.index')->with('success', __('form_update_slider_success'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sliders = Slider::find($id);

        if (!$sliders) {
            return redirect()->route('sliders.index')->with('error', '[E18]'.__('slider_not_found.'));
        }

        try {
            if ($sliders->image_url && File::exists(public_path($sliders->image_url))) {
                File::delete(public_path($sliders->image_url));
            }
            $sliders->delete();
        } catch (Exception $e) {
            return redirect()->route('sliders.index')->with('error', '[E19] ' . __('slider_delete_error'));
        }
        return redirect()->route('sliders.index')->with('success',  __('slider_deleted_successfully'));

    }
}
