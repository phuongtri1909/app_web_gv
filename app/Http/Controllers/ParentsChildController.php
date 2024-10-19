<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\ParentsChild;
use App\Models\ParentsChildDetail;
use App\Models\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class ParentsChildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }


    public function indexParents($id)
    {
        $tab = Tab::findOrFail($id);
        $parentsChildren = ParentsChild::where('tab_id', $tab->id)->get();
        return view('admin.pages.tab_parent.parents_child.show_parent_child', compact('tab', 'parentsChildren'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    }
    public function createContent($id)
    {

        $tab = Tab::find($id);
        if (!$tab) {
            return back()->with('error', __('no_find_data'));
        }
        $languages = Language::all();
        return view('admin.pages.tab_parent.parents_child.create', compact('tab', 'languages'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeContent(Request $request, $tab_id)
    {
        $locales = Language::pluck('locale')->toArray();
        $tab = Tab::findOrFail($tab_id);
        $rules = [
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'component_type' => 'required|string',
        ];
        $messages = [
            'image.image' => __('image_image'),
            'image.mimes' => __('image_mimes'),
            'component_type.required' => __('component_type_required'),
        ];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["description_{$locale}"] = 'nullable|string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["description_{$locale}.string"] = __('description_string');
        }

        $validatedData = $request->validate($rules, $messages);

        try {
            $translateTitle = [];
            $translateDescription = [];
            $translateDuration = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateDescription[$locale] = $request->get("description_{$locale}");
                $translateDuration[$locale] = $request->get("duration_{$locale}");
            }
            try {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/parents/' . $folderName), $fileName);
                    $image_path = 'uploads/images/parents/' . $folderName . '/' . $fileName;
                } else {
                    $image_path = null;
                }
            } catch (\Exception $e) {
                if (isset($image_path) && File::exists(public_path($image_path))) {
                    File::delete(public_path($image_path));
                }
                return back()->withInput()->with('error', __('upload_image_error'));
            }

            $slug = Str::slug($translateTitle[config('app.locale')]);
            if (ParentsChild::where('slug', $slug)->exists()) {
                return redirect()->back()->with('error', __('slug_exists'));
            }
            $tab_content = new ParentsChild();
            $tab_content->setTranslations('title', $translateTitle);
            $tab_content->setTranslations('description', $translateDescription);
            $tab_content->setTranslations('duration', $translateDuration);
            $tab_content->image = $image_path;
            $tab_content->component_type = $request->component_type;
            $tab_content->slug = $slug;
            $tab_content->link = $request->link;
            $tab_content->tab_id = $tab->id;
            $tab_content->save();

            return redirect()->route('parents-children.index', $tab_content->tab_id)->with('success', __('create_content_tab_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('create_content_tab_error')])->withInput();
        }
    }

    public function editContent($id)
    {
        $tab_content = ParentsChild::where('id', $id)->first();
        if (!$tab_content) {
            return back()->with('error', __('no_content_found'));
        }

        $languages = Language::all();
        return view('admin.pages.tab_parent.parents_child.edit', compact('tab_content', 'languages'));
    }


    public function updateContent(Request $request, $id)
    {
        $locales = Language::pluck('locale')->toArray();
        $tab_content = ParentsChild::findOrFail($id);


        $rules = [
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'component_type' => 'required|string',
        ];
        $messages = [
            'image.image' => __('image_image'),
            'image.mimes' => __('image_mimes'),
            'component_type.required' => __('component_type_required'),
        ];

        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'string|max:255';
            $rules["description_{$locale}"] = 'nullable|string';

            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["description_{$locale}.string"] = __('description_string');
        }

        $validatedData = $request->validate($rules, $messages);

        if ($request->has('delete_image')) {
            if ($tab_content->image && File::exists(public_path($tab_content->image))) {
                File::delete(public_path($tab_content->image));
                $tab_content->image = null;
            }
        }
        try {
            $translateTitle = [];
            $translateDescription = [];
            $translateDuration = [];

            foreach ($locales as $locale) {
                $translateTitle[$locale] = $request->get("title_{$locale}");
                $translateDescription[$locale] = $request->get("description_{$locale}");
                $translateDuration[$locale] = $request->get("duration_{$locale}");
            }

            if ($request->hasFile('image')) {
                if ($tab_content->image && File::exists(public_path($tab_content->image))) {
                    File::delete(public_path($tab_content->image));
                }

                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/parents/' . $folderName), $fileName);
                    $image_path = 'uploads/images/parents/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    return back()->withInput()->with('error', __('upload_image_error'));
                }

                $tab_content->image = $image_path;
            }

            $slug = Str::slug($translateTitle[config('app.locale')]);
            if (ParentsChild::where('slug', $slug)->where('id', '<>', $tab_content->id)->exists()) {
                return redirect()->back()->with('error', __('slug_exists'));
            }

            $tab_content->setTranslations('title', $translateTitle);
            $tab_content->setTranslations('description', $translateDescription);
            $tab_content->setTranslations('duration', $translateDuration);
            $tab_content->component_type = $request->component_type;
            $tab_content->slug = $slug;
            $tab_content->link = $request->link;
            $tab_content->save();

            return redirect()->route('parents-children.index', $tab_content->tab_id)->with('success', __('update_content_tab_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return back()->with(['error' => __('update_content_tab_error')])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentsChild $parentsChild)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentsChild $parentsChild)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParentsChild $parentsChild)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        try {
            $tab_image_content = ParentsChild::find($id);


            if (!$tab_image_content) {
                return back()->with('error', __('no_find_data'));
            }
            $tab_image_content->delete();

            return redirect()->route('parents-children.index', $tab_image_content->tab_id)->with('success', __('delete_success'));

        } catch (\Exception $e) {
            return back()->with(['error' => __('delete_error') . $e->getMessage()]);
        }
    }

    public function showParentChildDetail($id)
    {
        $tab_projects = ParentsChild::findOrFail($id);
        $mediaItems = ParentsChildDetail::where('parents_child_id', $id)->get();

        return view('admin.pages.tab_parent.parents_child_detail.index', compact('mediaItems','tab_projects'));
    }
    public function createParentChildDetail($id)
    {
        $tabContent = ParentsChild::findOrFail($id);
        return view('admin.pages.tab_parent.parents_child_detail.create', compact('tabContent'));
    }
    public function storeParentChildDetail(Request $request, $id)
    {
        $rules = [
            'files.*' => 'required|mimes:jpg,png,jpeg|max:20480',
        ];

        $messages = [
            'files.*.required' => __('file_required'),
            'files.*.mimes' => __('file_mimes'),
            'files.*.max' => __('file_max'),
        ];

        $request->validate($rules, $messages);

        $invalidFiles = [];
        $filePaths = [];

        try {
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    try {
                        $extension = $file->getClientOriginalExtension();

                        if (!in_array($extension, ['jpg', 'png', 'jpeg'])) {
                            $invalidFiles[] = $file->getClientOriginalName();
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
                    ])
                ])->withInput();
            }

            foreach ($filePaths as $filePath) {
                $mediaItem = new ParentsChildDetail();
                $mediaItem->parents_child_id = $id;
                $mediaItem->image = $filePath;
                $mediaItem->save();
            }

            return redirect()->route('ParentChildDetail.index.detail', $id)->with('success', __('create_success'));

        } catch (\Exception $e) {
            foreach ($filePaths as $path) {
                if (File::exists(public_path($path))) {
                    File::delete(public_path($path));
                }
            }
            return back()->with(['error' => __('update_content_error')])->withInput();
        }
    }

    public function editParentChildDetail($tab_id, $detail_id)
    {
        $mediaItem = ParentsChildDetail::findOrFail($detail_id);
        if (!$mediaItem) {
            return back()->with('error', __('no_find_data'));
        }
        return view('admin.pages.tab_parent.parents_child_detail.edit', compact('mediaItem'));
    }

    public function updateParentChildDetail(Request $request, $tab_id, $detail_id)
    {
        $mediaItem = ParentsChildDetail::findOrFail($detail_id);

        $rules = [
            'file' => 'nullable|mimes:jpg,png,jpeg|max:20480',
        ];

        $messages = [
            'file.mimes' => __('file_mimes'),
            'file.max' => __('file_max'),
        ];

        $request->validate($rules, $messages);
        $filePath = $mediaItem->image;

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                if (!in_array($extension, ['jpg', 'png', 'jpeg'])) {
                    return back()->with(['error' => __('file_mimes_invalid')])->withInput();
                }
                if ($mediaItem->image && File::exists(public_path($mediaItem->image))) {
                    File::delete(public_path($mediaItem->image));
                }
                $folderName = date('Y/m');
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $file->move(public_path('/uploads/media/' . $folderName), $fileName);
                $filePath = 'uploads/media/' . $folderName . '/' . $fileName;
            }


            $mediaItem->image = $filePath;
            $mediaItem->save();

            return redirect()->route('ParentChildDetail.index.detail', $tab_id)
                ->with('success', __('update_success'));
        } catch (\Exception $e) {

            if (isset($filePath) && File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }
            return back()->with(['error' => __('update_content_tab_error')])->withInput();
        }
    }

    public function destroyParentChildDetail($tab_id, $detail_id)
    {
        try {

            $mediaItem = ParentsChildDetail::findOrFail($detail_id);

            if ($mediaItem->image && File::exists(public_path($mediaItem->image))) {
                File::delete(public_path($mediaItem->image));
            }

            $mediaItem->delete();
            return redirect()->route('ParentChildDetail.index.detail', $tab_id)->with('success', __('delete_success'));
        } catch (\Exception $e) {
            return back()->with(['error' => __('delete_error') . $e->getMessage()]);
        }

    }
}

