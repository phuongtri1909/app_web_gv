<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $papers = Paper::orderBy('created_at', 'desc')->get();
        return view('admin.pages.papers.index', compact('papers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $papers = Paper::all();
        return view('admin.pages.papers.create',compact('papers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'avatar' => 'required|image',
            'short_description' => 'required|string',
        ];

        $messages = [
            'name.required' => __('form.name.required'),
            'name.string' => __('form.name.string'),
            'name.max' => __('form.name.max'),
            'avatar.required' => __('form.avatar.required'),
            'avatar.image' => __('form.avatar.image'),
            'short_description.required' => __('form.short_description.required'),
            'short_description.string' => __('form.short_description.string'),
        ];

        $request->validate($rules, $messages);

        try {

            try {
                $image = $request->file('avatar');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $avatarName = $originalFileName . '-' . time() . '.' . $extension;
                $image->move(public_path('uploads/papers/' .  $folderName), $avatarName);
                $imageFilePath = 'uploads/papers/' .  $folderName . '/' . $avatarName;
            } catch (Exception $e) {
                if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                    File::delete(public_path($imageFilePath));
                }
                return back()->withInput()->with('error', '[E20] ' . __('create_error'));
            }

            Paper::create([
                'name' => $request->input('name'),
                'avatar' => $imageFilePath,
                'short_description' => $request->input('short_description'),
                'link' => $request->input('link'),
            ]);

        } catch (QueryException $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error', '[E21] ' . __('create_error'));
        }
        return redirect()->route('papers.index')->with('success', __('create_success'));

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
    public function edit( $id)
    {
        $papers = Paper::find($id);

        if (!$papers) {
            return redirect()->route('papers.index')->with('error', '[E13] ' . __('no_find_data'));
        }

        return view('admin.pages.papers.edit', compact('papers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $papers = Paper::find($id);

        if (!$papers) {
            return redirect()->route('papers.index')->with('error', '[E19] ' . __('no_find_data'));
        }

        try {
            $imageFilePath = $papers->avatar;

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $avatarName = $originalFileName . '-' . time() . '.' . $extension;
                $image->move(public_path('uploads/papers/' . $folderName), $avatarName);
                $imageFilePath = 'uploads/papers/' . $folderName . '/' . $avatarName;

                if (isset($papers->avatar) && File::exists(public_path($papers->avatar))) {
                    File::delete(public_path($papers->avatar));
                }
            }

            $papers->update([
                'name' => $request->input('name'),
                'avatar' => $imageFilePath,
                'short_description' => $request->input('short_description'),
                'link' => $request->input('link'),
            ]);

        } catch (QueryException $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error', '[E21] ' . __('update_error_db'));
        } catch (Exception $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error', '[E22] ' . __('update_error'));
        }

        return redirect()->route('papers.index')->with('success', __('update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $papers = Paper::find($id);

        if (!$papers) {
            return redirect()->route('papers.index')->with('error', '[E23] ' . __('no_find_data'));
        }

        try {
            if ($papers->avatar && File::exists(public_path($papers->avatar))) {
                File::delete(public_path($papers->avatar));
            }

            $papers->delete();
        return redirect()->route('papers.index')->with('success', __('Data_deleted_successfully'));

        } catch (Exception $e) {
            return redirect()->route('papers.index')->with('error', '[E14] ' . __('delete_error'));

        }

    }
}
