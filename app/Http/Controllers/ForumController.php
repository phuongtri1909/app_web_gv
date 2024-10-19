<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\Language;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::orderBy('created_at', 'desc')->get();
        return view('admin.pages.forum.index', compact('forums'));
    }

    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.forum.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $locales = Language::pluck('locale')->toArray();
        $rules = $this->getValidationRules($locales);
        $messages = $this->getValidationMessages($locales);
        $request->validate($rules, $messages);

        try {
            $forum = new Forum();
            $imagePaths = $this->handleImageUpload($request);
            $translationsTitle = $this->getTranslationsTitle($request, $locales);

            $forum->setTranslations('title', $translationsTitle);
            $forum->key_page = $request->input('key_page');
            $forum->active = $request->input('active');
            if ($request->input('key_page') === 'key_forum_cp3') {
                $forum->image = json_encode($imagePaths);
            } else {
                $forum->image = $imagePaths[0] ;
            }

            $forum->save();

            return redirect()->route('forums.index')->with('success', __('forum_created successfully'));
        } catch (QueryException $e) {
            $this->cleanupImages($imagePaths);
            return back()->withInput()->with('error', $e->getMessage());
            // return back()->withInput()->with('error', '[E16] ' . __('forum_create_error_db'));
        } catch (Exception $e) {
            $this->cleanupImages($imagePaths);
            return back()->withInput()->with('error', '[E17] ' . __('create_new_forum_error'));
        }
    }

    public function edit($id)
    {
        $forum = Forum::find($id);
        $languages = Language::all();
        if (!$forum) {
            return redirect()->back()->with('error', __('no_content_found'));
        }
        $translatedTitlesAlt = json_decode($forum->getAttributes()['title'], true);
        return view('admin.pages.forum.edit', compact('forum', 'languages', 'translatedTitlesAlt'));
    }

    public function update(Request $request, $id)
    {
        $locales = Language::pluck('locale')->toArray();
        $rules = $this->getValidationRules($locales);
        $messages = $this->getValidationMessages($locales);
        $request->validate($rules, $messages);

        $forum = Forum::findOrFail($id);
        $currentImages = json_decode($forum->image, true) ?? [];
        try {
            if ($request->has('delete_images')) {
                foreach ($request->input('delete_images') as $indexToDelete) {
                    if (isset($currentImages[$indexToDelete])) {
                        $this->deleteImageFile($currentImages[$indexToDelete]);
                        unset($currentImages[$indexToDelete]);
                    }
                }
                $currentImages = array_values($currentImages);
            }
            if ($request->hasFile('image')) {
                $newImages = $this->handleImageUpload($request);
                $totalImages = count($currentImages) + count($newImages);

                if ($totalImages > 9) {
                    return back()->withInput()->with('error',  __('image_10'));
                }
                $currentImages = array_merge($currentImages, $newImages);
            }
            if ($request->input('key_page') === 'key_forum_cp3') {
                $forum->image = json_encode(array_values($currentImages));
            } else {
                $forum->image = isset($currentImages[0]) ? $currentImages[0] : null;
            }

            $translationsTitle = $this->getTranslationsTitle($request, $locales);

            $forum->setTranslations('title', $translationsTitle);
            $forum->key_page = $request->input('key_page');
            $forum->active = $request->input('active');

            $forum->save();

            return redirect()->route('forums.index')->with('success', __('forum_updated_successfully'));
        } catch (QueryException $e) {
            $this->cleanupImages($currentImages);
            return back()->withInput()->with('error', '[E16] ' . __('forum_update_error_db'));
        } catch (Exception $e) {
            $this->cleanupImages($currentImages);
            // return back()->withInput()->with('error', '[E17] ' . __('update_forum_error'));
            return back()->withInput()->with('error', '[E17] ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return redirect()->route('forums.index')->with('error', '[E18] ' . __('forum_not_found'));
        }

        try {
            $this->cleanupImages($forum->image);
            $forum->delete();
        } catch (Exception $e) {
            return redirect()->route('forums.index')->with('error', '[E19] ' . __('forum_delete_error'));
        }

        return redirect()->route('forums.index')->with('success', __('forum_deleted_successfully'));
    }

    private function getValidationRules($locales)
    {
        $rules = [
           'image.*' => 'image|mimes:jpg,png,jpeg|max:2048',
           'image' => 'array|max:9',
           'key_page' => 'required|string|max:255',
           'active' => 'required|in:yes,no',
        ];

        foreach ($locales as $locale) {
            $rules["title-{$locale}"] = 'required|string';
        }

        return $rules;
    }

    private function getValidationMessages($locales)
    {
        $messages = [
            'image.required' => __('form.image.required'),
            'image.mimes' => __('image_mimes'),
            'image.max' => __('image_10'),
            'key_page.required' => __('form.key_page.required'),
            'active.required' => __('form.active.required'),
            'active.in' => __('form.active.in'),
        ];

        foreach ($locales as $locale) {
            $messages["title-{$locale}.required"] = __('form.title.required', ['locale' => $locale]);
        }

        return $messages;
    }

    private function handleImageUpload(Request $request, $existingImages = null)
    {
        $imagePaths = [];
        $invalidFiles = [];

        if ($request->hasFile('image')) {
            $folderName = date('Y/m');
            $files = $request->file('image');
            if ($request->input('key_page') === 'key_forum_cp3') {
                if (count($files) > 9) {
                    return back()->withInput()->with('error',  __('image_10'));
                }
                foreach ($request->file('image') as $imageFile) {
                    $imagePaths[] = $this->processImage($imageFile, $folderName, $invalidFiles);
                }
            } else {
                $imageFile = $request->file('image')[0];
                $imagePaths[] = $this->processImage($imageFile, $folderName, $invalidFiles);
            }

            if (!empty($invalidFiles)) {
                return back()->withInput()->with(['error' => __('file_mimes_invalid')]);
            }

            if ($existingImages) {
                $this->cleanupImages($existingImages);
            }
        }

        return $imagePaths;
    }


    private function processImage($imageFile, $folderName, &$invalidFiles)
    {
        $extension = strtolower($imageFile->getClientOriginalExtension());

        if (!in_array($extension, ['jpg', 'png', 'jpeg'])) {
            return back()->withInput()->with(['error' => __('file_mimes_invalid')]);
        }

        $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $imageFileName = $originalFileName . '_' . time() . '.' . $extension;
        $uploadPath = public_path('uploads/images/forums/' . $folderName);

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $image = Image::make($imageFile->getRealPath());
        $image->save($uploadPath . '/' . $imageFileName, 75);

        return 'uploads/images/forums/' . $folderName . '/' . $imageFileName;
    }

    private function cleanupImages($images)
    {
        if ($images) {
            $imagesArray = is_array($images) ? $images : json_decode($images, true);
            foreach ($imagesArray as $image) {
                if (File::exists(public_path($image))) {
                    File::delete(public_path($image));
                }
            }
        }
    }
    private function deleteImageFile($imagePath)
    {
        if (File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }
    }
    private function getTranslationsTitle(Request $request, $locales)
    {
        $translationsTitle = [];
        foreach ($locales as $locale) {
            $translationsTitle[$locale] = $request->input("title-{$locale}");
        }

        return $translationsTitle;
    }
}
