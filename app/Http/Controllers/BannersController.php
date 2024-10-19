<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\QueryException;


class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banners::orderBy('created_at', 'desc')->get();
        return view('admin.pages.banners.index', compact('banners'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banners = Banners::all();
        return view('admin.pages.banners.create',compact('banners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'path' => 'required|file|mimetypes:image/jpeg,image/png,image/jpg,video/mp4,video/avi,video/mov,video/wmv',
            'key_page' => 'required|string',
            'active' => 'required|in:yes,no',
            'thumbnail' => 'required|image',
        ];

        $messages = [
            'path.required' => __('form.path.required'),
            'path.file' => __('form.path.file'),
            'path.mimes' => __('form.path.mimes'),
            'path.max' => __('form.path.max'),
            'key_page.required' => __('form.key_page.required'),
            'active.required' => __('form.active.required'),
            'active.in' => __('form.active.in'),
            'thumbnail.file' => __('form.thumbnail.file'),
            'thumbnail.mimes' => __('form.thumbnail.mimes'),
            'thumbnail.max' => __('form.thumbnail.max'),
            'thumbnail.required' => __('form.thumbnail.required'),

        ];

        $request->validate($rules, $messages);

        try {
            $videoFilePath = null;
            try {
                $videoFile = $request->file('path');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $videoFile->getClientOriginalExtension();
                $videoFileName = $originalFileName . '_' . time() . '.' . $extension;
                $videoFile->move(public_path('uploads/banners/' .  $folderName), $videoFileName);
                $videoFilePath = 'uploads/banners/' .  $folderName . '/' . $videoFileName;
            } catch (Exception $e) {
                return back()->withInput()->with('error', '[E6] ' . __('form.path.required'));
            }

            $thumbnailFilePath = null;
            try {
                if ($request->hasFile('thumbnail')) {
                    $thumbnailFile = $request->file('thumbnail');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($thumbnailFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $thumbnailFile->getClientOriginalExtension();
                    $thumbnailFileName = $originalFileName . '_' . time() . '.' . $extension;
                    $thumbnailFile->move(public_path('uploads/images/thumbnails/' .  $folderName), $thumbnailFileName);
                    $thumbnailFilePath = 'uploads/images/thumbnails/' .  $folderName . '/' . $thumbnailFileName;
                }
            } catch (Exception $e) {
                if ($videoFilePath && File::exists(public_path($videoFilePath))) {
                    File::delete(public_path($videoFilePath));
                }
                return back()->withInput()->with('error', '[E7] ' . __('form.thumbnail_error'));
            }

            Banners::create([
                'path' => $videoFilePath,
                'key_page' => $request->input('key_page'),
                'active' => $request->input('active'),
                'thumbnail' => $thumbnailFilePath,
            ]);

        } catch (QueryException $e) {
            if (isset($videoFilePath) && File::exists(public_path($videoFilePath))) {
                File::delete(public_path($videoFilePath));
            }
            return back()->withInput()->with('error', '[E8] ' . __('banner_create_error_db'));
        } catch (Exception $e) {
            if (isset($videoFilePath) && File::exists(public_path($videoFilePath))) {
                File::delete(public_path($videoFilePath));
            }
            if (isset($thumbnailFilePath) && File::exists(public_path($thumbnailFilePath))) {
                File::delete(public_path($thumbnailFilePath));
            }
            return back()->withInput()->with('error', '[E9] ' . __('create_new_banner_error'));
        }
        return redirect()->route('banners.index')->with('success', __('form.create_success'));
    }






    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banner = Banners::find($id);

        if (!$banner) {
            return redirect()->route('banners.index')->with('error', '[E13] ' . __('banner_not_found'));
        }

        return view('admin.pages.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = Banners::find($id);

        if (!$banner) {
            return redirect()->route('banners.index')->with('error', '[E12] ' . __('banner_not_found'));
        }
        $rules = [
           'path' => 'file|mimetypes:image/jpeg,image/png,image/jpg,video/mp4,video/avi,video/mov,video/wmv',
            'key_page' => 'required|string',
            'active' => 'required|in:yes,no',
            'thumbnail' => 'image',
        ];
        $messages = [
            'path.required' => __('form.path.required'),
            'path.file' => __('form.path.file'),
            'path.mimes' => __('form.path.mimes'),
            'path.max' => __('form.path.max'),
            'key_page.required' => __('form.key_page.required'),
            'active.required' => __('form.active.required'),
            'active.in' => __('form.active.in'),
            'thumbnail.file' => __('form.thumbnail.file'),
            'thumbnail.mimes' => __('form.thumbnail.mimes'),
            'thumbnail.max' => __('form.thumbnail.max'),
        ];
        $request->validate($rules, $messages);
        try {
            $videoFilePath = $banner->path;

            if ($request->hasFile('path')) {
                if (File::exists(public_path($banner->path))) {
                    File::delete(public_path($banner->path));
                }

                $videoFile = $request->file('path');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $videoFile->getClientOriginalExtension();
                $videoFileName = $originalFileName . '_' . time() . '.' . $extension;
                $videoFile->move(public_path('uploads/banners/' .  $folderName), $videoFileName);
                $videoFilePath = 'uploads/banners/' .  $folderName . '/' . $videoFileName;
            }

            $thumbnailFilePath = $banner->thumbnail;
            if ($request->hasFile('thumbnail')) {
                if (File::exists(public_path($banner->thumbnail))) {
                    File::delete(public_path($banner->thumbnail));
                }

                $thumbnailFile = $request->file('thumbnail');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($thumbnailFile->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $thumbnailFile->getClientOriginalExtension();
                $thumbnailFileName = $originalFileName . '_' . time() . '.' . $extension;
                $thumbnailFile->move(public_path('uploads/images/thumbnails/' .  $folderName), $thumbnailFileName);
                $thumbnailFilePath = 'uploads/images/thumbnails/' .  $folderName . '/' . $thumbnailFileName;
            }

            $banner->path = $videoFilePath;
            $banner->thumbnail = $thumbnailFilePath;
            $banner->key_page = $request->input('key_page');
            $banner->active = $request->input('active');
            $banner->save();

            return redirect()->route('banners.index')->with('success', __('form.update_success'));

        } catch (QueryException $e) {
            if (isset($videoFilePath) && File::exists(public_path($videoFilePath))) {
                File::delete(public_path($videoFilePath));
            }
            if (isset($thumbnailFilePath) && File::exists(public_path($thumbnailFilePath))) {
                File::delete(public_path($thumbnailFilePath));
            }
            return back()->withInput()->with('error', '[E10] ' . __('banner_update_error_db'));
        } catch (Exception $e) {
            if (isset($videoFilePath) && File::exists(public_path($videoFilePath))) {
                File::delete(public_path($videoFilePath));
            }
            if (isset($thumbnailFilePath) && File::exists(public_path($thumbnailFilePath))) {
                File::delete(public_path($thumbnailFilePath));
            }
            return back()->withInput()->with('error', '[E11] ' . __('update_banner_error'));
        }
    }



    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    $banner = Banners::find($id);

    if (!$banner) {
        return redirect()->route('banners.index')->with('error', '[E12] ' . __('banner_not_found'));
    }

    try {
        if ($banner->path && File::exists(public_path($banner->path))) {
            File::delete(public_path($banner->path));
        }

        if ($banner->thumbnail && File::exists(public_path($banner->thumbnail))) {
            File::delete(public_path($banner->thumbnail));
        }
        $banner->delete();

        return redirect()->route('banners.index')->with('success', __('banner_deleted_successfully'));
    } catch (Exception $e) {
        return redirect()->route('banners.index')->with('error', '[E14] ' . __('banner_delete_error'));
    }
}

}
