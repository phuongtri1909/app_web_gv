<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\MediaItem;
use App\Models\Tab;
use App\Models\TabImgContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class EvironmentController extends Controller
{

    public function index()
    {
        $tabs_environments = Tab::where('key_page', 'environment')->get();
        return view('admin.pages.environment.index', compact('tabs_environments'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($slug)
    {
        return $this->tabEnvironment(request(), $slug);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function editContent($id)
    {
        $tab_image_content = TabImgContent::where('id', $id)->first();
        $languages = Language::all();

        if (!$tab_image_content) {
            return redirect()->back()->with('error', __('no_content_found'));
        }
        return view('admin.pages.environment.edit', compact('tab_image_content', 'languages'));


    }
    public function updateContent(Request $request, $id)
    {
        $tab_image_content = TabImgContent::findOrFail($id);

        if (!$tab_image_content) {
            return redirect()->back()->with('error', __('no_content_found'));
        }

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

        if ($request->hasFile('image')) {
            $rules['image'] = 'mimes:jpg,jpeg,png,gif|max:20480';
            $messages['image.mimes'] = __('image_mimes');
            $messages['image.max'] = __('image_max');
        }
        $rules['section_type'] = 'nullable|string|max:50';
        $messages['section_type.string'] = __('section_type_string');
        $messages['section_type.max'] = __('section_type_max', ['max' => 50]);

        $validatedData = $request->validate($rules, $messages);

        try {
            if ($request->has('delete_image') && $tab_image_content->image) {
                if (File::exists(public_path($tab_image_content->image))) {
                    File::delete(public_path($tab_image_content->image));
                }
                $tab_image_content->image = null;
            }

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/content/' . $folderName), $fileName);
                    $image_path = 'uploads/images/content/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }

                $backupImage = $tab_image_content->image;
                $tab_image_content->image = $image_path;
            }

            $translateTitle = [];
            $translateContent = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateContent[$locale] = $request->get("content_{$locale}");
            }

            $tab_image_content->setTranslations('title', $translateTitle);
            $tab_image_content->setTranslations('content', $translateContent);
            $tab_image_content->section_type = $request->input('section_type');
            $tab_image_content->save();

            if (isset($backupImage) && File::exists(public_path($backupImage))) {
                File::delete(public_path($backupImage));
            }

            return redirect()->route('show_content', $tab_image_content->tab_id)->with('success', __('update_success'));

        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('update_error') . $e->getMessage()])->withInput();
        }
    }


    public function createContent($id)
    {
        $tab = Tab::find($id);
        if (!$tab) {
            return back()->with('error', __('no_find_data'));
        }
        $languages = Language::all();
        return view('admin.pages.environment.create', compact('tab', 'languages'));
    }


    public function storeContent(Request $request, $id)
    {

        $locales = Language::pluck('locale')->toArray();

        $rules = [];
        $messages = [];

        $rules = [
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'section_type' => 'nullable|string|max:50',

        ];
        $messages = [
            'image.image' => __('image_image'),
            'image.mimes' => __('image_mimes'),
            'section_type.string' => __('section_type_string'),
            'section_type.max' => __('section_type_max', ['max' => 50])

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

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/tab_content/' . $folderName), $fileName);
                    $image_path = 'uploads/images/tab_content/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }
            }

            $tab_content = new TabImgContent();
            $tab_content->setTranslations('title', $translateTitle);
            $tab_content->setTranslations('content', $tranSlateContent);
            $tab_content->image = $image_path;
            $tab_content->section_type = $request->input('section_type');
            $tab_content->tab_id = $id;
            $tab_content->save();
            return redirect()->route('show_content', $id)->with('success', __('create_content_tab_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            // dd($e);
            return back()->with(['error' => __('create_content_tab_error')])->withInput();
        }

    }

    public function destroyContent($tab_id, $id)
    {
        $tab = Tab::findOrFail($tab_id);
        if (!$tab) {
            return back()->with('error', __('no_find_data'));
        }
        try {
            $tab_drop_content = TabImgContent::findOrFail($id);
            if ($tab_drop_content->image && File::exists(public_path($tab_drop_content->image))) {
                File::delete(public_path($tab_drop_content->image));
            }
            $tab_drop_content->delete();
            return redirect()->route('show_content', $tab_id)->with('success', __('delete_tab_success'));
        } catch (\Exception $e) {
            return redirect()->route('show_content', $tab_id)->with('error', __('delete_tab_error'));
        }
    }

    public function destroy($id)
    {

    }


    public function tabEnvironment(Request $request, $slug)
    {
        $tab = Tab::where('slug', $slug)->first();
        if (!$tab) {
            return view('pages.learn-env')->with('error', __('tab_not_found'));
        }
        $tab_img_content = TabImgContent::where('tab_id', $tab->id)->get();
        if (!$tab_img_content) {
            return view('pages.learn-env', compact('tab', 'tab_img_content'));
        }
        switch ($tab->slug) {
            case 'learn-environment':
                $section_1 = TabImgContent::where('tab_id', $tab->id)
                    ->where('section_type', 'section_1')
                    ->first();
                $section_2 = TabImgContent::where('tab_id', $tab->id)
                    ->where('section_type', 'section_2')
                    ->get();

                $section_3 = TabImgContent::where('tab_id', $tab->id)
                    ->where('section_type', 'section_3')
                    ->get();
                return view('pages.learn-env', compact('tab', 'tab_img_content', 'section_1', 'section_2', 'section_3'));
                break;
            default:
                $component_2 = $tab->imgContents->where('section_type','component_1')->first();
                        
                $components_3 = $tab->imgContents()->where('section_type','component_2')->get();

                return view('pages.tab-custom.index', compact('tab','component_2','components_3'));
                break;
        }

    }

    public function showDetailTab($id)
    {
        $mediaItem = MediaItem::where('tabs_img_content_id', $id)->get();
        // if ($mediaItem->isEmpty()) {
        //     abort(404);
        // }
        // dd($mediaItem );
        return view('pages.detail-learn-env', compact('mediaItem'));
    }

    public function show_content($id)
    {
        $tab = Tab::findOrFail($id);
        $tab_image_content = TabImgContent::where('tab_id', $tab->id)->get();

        // if ($tab_image_content->isEmpty()) {
        //     return redirect()->back()->with('error', __('no_content_found'));
        // }
        $languages = Language::all();
        return view('admin.pages.environment.show_content', compact('tab', 'tab_image_content', 'languages'));
    }
    public function show_content_detail($id)
    {
        $tabContent = TabImgContent::findOrFail($id);

        $mediaItems = MediaItem::where('tabs_img_content_id', $id)->get();

        return view('admin.pages.environment.show_detail.show_detail', compact('tabContent', 'mediaItems'));

    }

    public function createDetail($id)
    {
        $tabContent = TabImgContent::findOrFail($id);
        return view('admin.pages.environment.show_detail.create_detail', compact('tabContent'));
    }

    public function storeDetail(Request $request, $id)
    {
        $rules = [
            'files.*' => 'required|mimes:jpg,png,jpeg,mp4|max:20480',
            'type' => 'required|in:image,video'
        ];

        $messages = [
            'files.*.required' => __('file_required'),
            'files.*.mimes' => __('file_mimes'),
            'files.*.max' => __('file_max'),
            'type.required' => __('type_required'),
            'type.in' => __('type_in'),
        ];

        $request->validate($rules, $messages);
        $type = $request->input('type');
        $invalidFiles = [];
        $filePaths = [];

        try {
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    try {
                        $extension = $file->getClientOriginalExtension();

                        if (
                            ($type === 'image' && !in_array($extension, ['jpg', 'png', 'jpeg'])) ||
                            ($type === 'video' && $extension !== 'mp4')
                        ) {
                            $invalidFiles[] = $file->getClientOriginalName();
                            continue;
                        }

                        $folderName = date('Y/m');
                        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $fileName = $originalFileName . '_' . time() . '.' . $extension;

                        $file->move(public_path('/uploads/media/' . $folderName), $fileName);
                        $filePath = 'uploads/media/' . $folderName . '/' . $fileName;
                        $filePaths[] = $filePath;

                    } catch (\Exception $e) {
                        foreach ($filePaths as $path) {
                            if (File::exists(public_path($path))) {
                                File::delete(public_path($path));
                            }
                        }
                        return back()->withInput()->with('error', __('upload_media_error'));
                    }
                }
            }

            if (!empty($invalidFiles)) {
                return back()->withErrors([
                    'files' => __('file_mimes_invalid', [
                        'files' => implode(', ', $invalidFiles),
                        'type' => $type
                    ])
                ])->withInput();
            }

            foreach ($filePaths as $filePath) {
                $mediaItem = new MediaItem();
                $mediaItem->tabs_img_content_id = $id;
                $mediaItem->file_path = $filePath;
                $mediaItem->type = $request->type;
                $mediaItem->save();
            }

            return redirect()->route('tabs-environment.section.show.detail', $id)->with('success', __('create_success'));

        } catch (\Exception $e) {
            foreach ($filePaths as $path) {
                if (File::exists(public_path($path))) {
                    File::delete(public_path($path));
                }
            }
            return back()->with(['error' => __('update_content_error')])->withInput();
        }
    }





    public function editDetail($tab_id, $detail_id)
    {
        $mediaItem = MediaItem::findOrFail($detail_id);
        if (!$mediaItem) {
            return back()->with('error', __('no_find_data'));
        }
        return view('admin.pages.environment.show_detail.edit_detail', compact('mediaItem'));
    }

    public function updateDetail(Request $request, $tab_id, $detail_id)
    {
        $mediaItem = MediaItem::findOrFail($detail_id);

        $rules = [
            'file' => 'nullable|mimes:jpg,png,jpeg,mp4|max:20480',
            'type' => 'required|in:image,video'
        ];

        $messages = [
            'file.mimes' => __('file_mimes'),
            'file.max' => __('file_max'),
            'type.required' => __('type_required'),
            'type.in' => __('type_in'),
        ];

        $request->validate($rules, $messages);
        $type = $request->input('type');
        $filePath = $mediaItem->file_path;

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();

                if (
                    ($type === 'image' && !in_array($extension, ['jpg', 'png', 'jpeg'])) ||
                    ($type === 'video' && $extension !== 'mp4')
                ) {
                    return back()->with(['error' => __('file_mimes_invalid')])->withInput();

                }

                if ($mediaItem->file_path && File::exists(public_path($mediaItem->file_path))) {
                    File::delete(public_path($mediaItem->file_path));
                }

                $folderName = date('Y/m');
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $file->move(public_path('/uploads/media/' . $folderName), $fileName);
                $filePath = 'uploads/media/' . $folderName . '/' . $fileName;
            }

            $mediaItem->file_path = $filePath;
            $mediaItem->type = $request->type;
            $mediaItem->save();

            return redirect()->route('tabs-environment.section.show.detail', $tab_id)
                ->with('success', __('update_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('update_content_tab_error')])->withInput();
        }
    }


    public function destroyDetail($tab_id, $detail_id)
    {
        try {

            $mediaItem = MediaItem::findOrFail($detail_id);

            if ($mediaItem->image && File::exists(public_path($mediaItem->image))) {
                File::delete(public_path($mediaItem->image));
            }

            $mediaItem->delete();
            return redirect()->route('tabs-environment.section.show.detail', $tab_id)->with('success', __('delete_success'));
        } catch (\Exception $e) {
            return back()->with(['error' => __('delete_error') . $e->getMessage()]);
        }

    }
}
