<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();
        return view('admin.pages.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $testimonials = Testimonial::all();
        return view('admin.pages.testimonials.create',compact('testimonials'));
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
                $image->move(public_path('uploads/testimonials/' .  $folderName), $avatarName);
                $imageFilePath = 'uploads/testimonials/' .  $folderName . '/' . $avatarName;
            } catch (Exception $e) {
                if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                    File::delete(public_path($imageFilePath));
                }
                return back()->withInput()->with('error', '[E20] ' . __('testimonials_create_error'));
            }

            Testimonial::create([
                'name' => $request->input('name'),
                'avatar' => $imageFilePath,
                'short_description' => $request->input('short_description'),
            ]);

        } catch (QueryException $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error', '[E21] ' . __('testimonials_create_error'));
        }
        return redirect()->route('testimonials.index')->with('success', __('form.create_success'));

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
        $testimonials = Testimonial::find($id);

        if (!$testimonials) {
            return redirect()->route('testimonials.index')->with('error', '[E13] ' . __('testimonials_not_found'));
        }

        return view('admin.pages.testimonials.edit', compact('testimonials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $testimonials = Testimonial::find($id);

        if (!$testimonials) {
            return redirect()->route('testimonials.index')->with('error', '[E19] ' . __('testimonials_not_found'));
        }

        try {
            $imageFilePath = $testimonials->avatar;

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $avatarName = $originalFileName . '-' . time() . '.' . $extension;
                $image->move(public_path('uploads/testimonials/' . $folderName), $avatarName);
                $imageFilePath = 'uploads/testimonials/' . $folderName . '/' . $avatarName;

                if (isset($testimonials->avatar) && File::exists(public_path($testimonials->avatar))) {
                    File::delete(public_path($testimonials->avatar));
                }
            }

            $testimonials->update([
                'name' => $request->input('name'),
                'avatar' => $imageFilePath,
                'short_description' => $request->input('short_description'),
            ]);

        } catch (QueryException $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error', '[E21] ' . __('testimonials_update_error_db'));
        } catch (Exception $e) {
            if (isset($imageFilePath) && File::exists(public_path($imageFilePath))) {
                File::delete(public_path($imageFilePath));
            }
            return back()->withInput()->with('error', '[E22] ' . __('testimonials_update_error'));
        }

        return redirect()->route('testimonials.index')->with('success', __('form.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $testimonials = Testimonial::find($id);

        if (!$testimonials) {
            return redirect()->route('testimonials.index')->with('error', '[E23] ' . __('testimonials_not_found'));
        }

        try {
            if ($testimonials->avatar && File::exists(public_path($testimonials->avatar))) {
                File::delete(public_path($testimonials->avatar));
            }

            $testimonials->delete();
        return redirect()->route('testimonials.index')->with('success', __('testimonials_deleted_successfully'));

        } catch (Exception $e) {
            return redirect()->route('testimonials.index')->with('error', '[E14] ' . __('testimonials_delete_error'));

        }

    }
}
